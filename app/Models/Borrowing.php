<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $table = 'TBL_BORROWING';
    protected $primaryKey = 'BORROWING_ID';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'BOOK_ID',
        'USER_ID',
        'BORROW_DATE',
        'RETURN_DUE_DATE',
        'RETURN_DATE',
        'STATUS',
    ];

    protected $casts = [
        'BORROW_DATE' => 'date',
        'RETURN_DUE_DATE' => 'date',
        'RETURN_DATE' => 'date',
    ];
} 