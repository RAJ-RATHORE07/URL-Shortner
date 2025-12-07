<?php 

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    // SuperAdmin -> invite Admin in NEW company
    public function inviteAdmin(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',
            'email'        => 'required|email',
        ]);

        $company = \App\Models\Company::create([
            'name' => $request->company_name,
        ]);

        $token = Str::random(32);

        Invitation::create([
            'company_id' => $company->id,
            'invited_by' => Auth::id(),
            'email'      => $request->email,
            'role'       => 'admin',
            'token'      => $token,
        ]);

        // Abhi email nahi bhej rahe, sirf token dikhayenge
        return back()->with('success', 'Admin invited. Share this link: ' . url('/invite/accept/' . $token));
    }

    // Admin -> invite Admin/Member in same company
    public function inviteMember(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role'  => 'required|in:admin,member',
        ]);

        $user = Auth::user();
        $token = Str::random(32);

        Invitation::create([
            'company_id' => $user->company_id,
            'invited_by' => $user->id,
            'email'      => $request->email,
            'role'       => $request->role,
            'token'      => $token,
        ]);

        return back()->with('success', 'User invited. Share this link: ' . url('/invite/accept/' . $token));
    }

    public function showAcceptForm($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        return view('invite-accept', compact('invitation'));
    }

    public function accept(Request $request, $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        $request->validate([
            'name'     => 'required|string',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name'       => $request->name,
            'email'      => $invitation->email,
            'password'   => Hash::make($request->password),
            'role'       => $invitation->role,
            'company_id' => $invitation->company_id,
        ]);

        $invitation->update(['accepted_at' => now()]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
