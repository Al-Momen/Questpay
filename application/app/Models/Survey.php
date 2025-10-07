<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $casts = [
        'form_data' => 'array'
    ];

    public function author()
    {
        return $this->morphTo();
    }


    public function getAuthorNameAttribute()
    {
        if (!$this->author) {
            return null;
        }

        if ($this->author_type === \App\Models\Admin::class) {
            return [
                'author_name' => $this->author->name ?? null,
                'author_type' => 'Super Admin'
            ];
        }

        if ($this->author_type === \App\Models\User::class) {
            return [
                'author_name' => $this->author->fullname ?? null,
                'author_type' => 'User'
            ];
        }

        return null;
    }


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
