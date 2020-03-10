<?php

namespace App;

use App\Supports\DataViewer;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use DataViewer;

    protected $table = 'applications';
    protected $fillable = ['name', 'version', 'patch_date', 'description', 'is_maintenance'];

    public function group() {
        return $this->belongsTo(\App\Group::class);
    }

    public function packages() {
        return $this->hasMany(\App\Package::class);
    }
}
