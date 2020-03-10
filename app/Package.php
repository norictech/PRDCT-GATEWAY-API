<?php

namespace App;

use App\Supports\DataViewer;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use DataViewer;

    protected $table = 'packages';
    protected $fillable = ['name', 'number_of_month', 'is_active', 'description'];

    public function application() {
        return $this->belongsTo(\App\Application::class);
    }
}
