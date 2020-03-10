<?php

namespace App;

use App\Supports\DataViewer;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use DataViewer;

    protected $fillable = ['role_name', 'is_active', 'description'];

    public function users() {
        return $this->hasMany(\App\User::class);
    }

    public function accesses() {
        return $this->hasMany(\App\Access::class);
    }
}
