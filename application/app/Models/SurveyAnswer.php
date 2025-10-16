<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    protected $casts = [
        'answer' => 'array'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusBadge($status)
    {
        $html = '';
        if ($this->status == 1) {
            $html = '<span class="badge badge--success">' . trans('Active') . '</span>';
        } elseif ($this->status == 2) {
            $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
        } else {
            $html = '<span class="badge badge--danger">' . trans('Rejected') . '</span>';
        }
        return $html;
    }
}
