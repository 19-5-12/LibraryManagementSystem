<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'TBL_STUDENT';
    protected $primaryKey = 'STUDENT_ID';
    public $incrementing = false;
    protected $keyType = 'integer';
    public $timestamps = false; // Disable timestamps since we're using existing table

    protected $fillable = [
        'STUDENT_ID',
        'LAST_NAME',
        'FIRST_NAME',
        'MIDDLE_NAME',
        'SEX',
        'ADDRESS',
        'CONTACT_NUMBER',
        'EMAIL',
        'TIME_IN',
        'REGISTERED_DATE',
        'PASSWORD'
    ];

    protected $hidden = [
        'PASSWORD',
    ];

    protected $casts = [
        'TIME_IN' => 'datetime',
        'REGISTERED_DATE' => 'date',
        'STUDENT_ID' => 'integer'
    ];
} 