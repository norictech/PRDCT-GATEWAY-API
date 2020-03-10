<?php

namespace App;

use App\Supports\DataViewer;
use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    use DataViewer;

    protected $table = 'accesses';
    protected $fillable = ['role_id', 'menu'];

    public function role() {
        return $this->belongsTo(\App\Role::class);
    }
}
