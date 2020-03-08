<?php

namespace App;

use App\Role;
use App\Supports\DataViewer;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, DataViewer;

    protected $fillable = ['unique_id', 'name', 'email', 'password', 'role_id', 'group_id'];
    protected $hidden = ['unique_id', 'password', 'remember_token'];
    protected $allowed_filters = ['name', 'email'];
    protected $orderable = ['name', 'email', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles() {
        return $this->belongsTo(Role::class);
    }
}
