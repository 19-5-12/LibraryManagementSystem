<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookRequest extends Model
{
    protected $table = 'TBL_BOOK_REQUEST';
    protected $primaryKey = 'REQUEST_ID';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'STUDENT_ID',
        'REQUEST_DATE',
        'STATUS',
        'BOOK_ID',
        'RESOLUTION_DATE',
    ];

    protected $casts = [
        'REQUEST_DATE' => 'date',
        'RESOLUTION_DATE' => 'date',
    ];
} 