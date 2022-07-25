<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use SoftDeletes;

    //=========================================
    // Table's name in database
    //=========================================

    protected $table = 'tables';

    //=========================================
    // Fillable values
    //=========================================

    protected $fillable = [
        'table_name ', ''
    ];

    //=============================================================
    // Define soft delete dates.
    //=============================================================

    protected $dates = ['deleted_at'];

}
