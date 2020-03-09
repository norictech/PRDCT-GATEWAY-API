<?php

namespace App;

use App\Supports\DataViewer;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use DataViewer;

    protected $fillable = [
        'role_name', 'is_active', 'description'
    ];

    public function users() {
        return $this->hasMany(User::class);
    }
}
