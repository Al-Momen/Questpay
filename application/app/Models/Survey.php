<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $casts = [
        'form_data' => 'array'
    ];


    public function statusBadge($status)
    {
        $html = '';
        if ($this->status == 0) {
            $html = '<span class="badge badge--warning">' . trans('Inactive') . '</span>';
        } else {
            $html = '<span class="badge badge--success">' . trans('Active') . '</span>';
        }
        return $html;
    }
}
