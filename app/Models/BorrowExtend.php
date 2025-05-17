<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowExtend extends Model
{
    protected $table = 'TBL_BORROW_EXTEND';
    protected $primaryKey = 'EXTEND_ID';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'REQUEST_ID',
        'EXTEND_DATE',
        'STATUS',
        'RESOLUTION_DATE',
    ];

    protected $casts = [
        'EXTEND_DATE' => 'date',
        'RESOLUTION_DATE' => 'date',
    ];
} 