<?php

namespace App;

use App\Supports\DataViewer;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use DataViewer;

    protected $table = 'groups';
    protected $fillable = ['parent_id', 'name', 'prefix', 'description'];

    public function users() {
        return $this->hasMany(\App\User::class);
    }

    public function applications() {
        return $this->hasMany(\App\Application::class);
    }
}
