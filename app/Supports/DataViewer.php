<?php

namespace App\Supports;

use App\Helpers\Globals;

trait DataViewer {

    public function scopeAdvanced_filter($query) {
        return $this->process($query, request()->all())
                    ->paginate(request('limit', Globals::get_option_value('paginate')));
    }

    public function process($query, $request) {
        foreach ($request as $key => $value) {
            if ($value['mode'] == 'search_any')
                $this->search_any($query, $value['value']);
            if ($value['mode'] == 'equal')
                $query = $query->where($value['key'], $value['value']);
            if ($value['mode'] == 'contain')
                $query = $query->where($value['key'], 'like', '%'. $value['value'] .'%');
            if ($value['mode'] == 'lessthan')
                $query = $query->where($value['key'], '<=', $value['value']);
            if ($value['mode'] == 'morethan')
                $query = $query->where($value['key'], '>=', $value['value']);
            if ($value['mode'] == 'order')
                $this->order($query, $value);
        }

        return $query;
    }

    public function search_any($query, $value) {
        foreach ($this->allowed_filters as $key => $column) {
            if ($key == 0)
                $query = $query->where($column, 'like', '%' . $value . '%');
            $query = $query->orWhere($column, 'like', '%' . $value . '%');
        }

        return $query;
    }

    public function order($query, $value) {
        dd($value);
        $query = $query->orderBy($value['key'], $value['value']);

        return $query;
    }

    public function allowed_filters() {
        return implode(',', $this->allowed_filters);
    }

    public function orderable() {
        return implode(',', $this->orderable);
    }

}
