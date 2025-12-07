<?php

use App\Models\Company;
use App\Models\Url;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->company = Company::factory()->create(['name' => 'Test Company']);
});

function createUser($role, $companyId = null)
{
    return User::factory()->create([
        'name' => ucfirst($role),
        'email' => $role . '@example.com',
        'password' => Hash::make('password'),
        'role' => $role,
        'company_id' => $companyId,
    ]);
}

it('admin and member can create short urls', function () {
    $admin = createUser('admin', $this->company->id);
    $member = createUser('member', $this->company->id);

    // admin
    $this->actingAs($admin)
        ->post('/urls', ['original_url' => 'https://example.com'])
        ->assertRedirect('/urls');

    // member
    $this->actingAs($member)
        ->post('/urls', ['original_url' => 'https://example.org'])
        ->assertRedirect('/urls');

    expect(Url::count())->toBe(2);
});

it('superadmin cannot create short urls', function () {
    $super = createUser('superadmin', null);

    $this->actingAs($super)
        ->post('/urls', ['original_url' => 'https://example.com'])
        ->assertStatus(403);
});

it('admin can only see urls of their company', function () {
    $company2 = Company::factory()->create();
    $admin1 = createUser('admin', $this->company->id);
    $admin2 = createUser('admin', $company2->id);

    Url::factory()->create([
        'company_id' => $this->company->id,
        'user_id' => $admin1->id,
    ]);

    Url::factory()->create([
        'company_id' => $company2->id,
        'user_id' => $admin2->id,
    ]);

    $this->actingAs($admin1)
        ->get('/urls')
        ->assertSee($this->company->id)
        ->assertDontSee($company2->id);
});

it('member only sees their own urls', function () {
    $member1 = createUser('member', $this->company->id);
    $member2 = createUser('member', $this->company->id);

    Url::factory()->create([
        'company_id' => $this->company->id,
        'user_id' => $member1->id,
        'original_url' => 'https://a.com',
    ]);

    Url::factory()->create([
        'company_id' => $this->company->id,
        'user_id' => $member2->id,
        'original_url' => 'https://b.com',
    ]);

    $this->actingAs($member1)
        ->get('/urls')
        ->assertSee('https://a.com')
        ->assertDontSee('https://b.com');
});

it('short urls are publicly resolvable and redirect', function () {
    $admin = createUser('admin', $this->company->id);
    $url = Url::factory()->create([
        'company_id' => $this->company->id,
        'user_id' => $admin->id,
        'original_url' => 'https://example.com',
        'short_code' => 'abc123',
    ]);

    $this->get('/s/' . $url->short_code)
        ->assertRedirect('https://example.com');
});
