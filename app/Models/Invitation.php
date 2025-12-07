<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'company_id',
        'role',
        'token',
        'accepted_at',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
