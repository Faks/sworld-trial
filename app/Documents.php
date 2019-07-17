<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_name',
        'file_extension',
        'file_mime_type',
        'file_size',
        'file_path',
    ];
}
