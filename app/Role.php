<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'role_name', 'status', 'description'
    ];

    public function users() {
        return $this->hasMany(User::class);
    }
}
