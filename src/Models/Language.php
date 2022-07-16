<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;

    //=========================================
    // Table's name in database
    //=========================================

    protected $table = 'languages';

    //=========================================
    // Fillable values
    //=========================================

    protected $fillable = [
         'abbr', 'name', 'direction', 'status'
    ];

    //=============================================================
    // Define soft delete dates.
    //=============================================================

    protected $dates = ['deleted_at'];

    //=============================================================
    // Scopes field. We usually define Selection scope.
    // We use this scope to return only the columns we need.
    //=============================================================

    public function scopeSelection($query)
    {
        return $query->select('id', 'abbr', 'name', 'direction', 'status');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    //=============================================================
    // Mutators field. We usually define Image mutator.
    // We use this mutator to specify images and icons path.
    // we just include the name of the field between 'get' and
    // 'Attribute' in camel case, then pass the value in the function
    // parameter
    //=============================================================

    public function getStatus()
    {
        return $this->status == 1 ? __('messages.Active') : __('messages.Inactive');
    }

    public function getDirectionAttribute($val)
    {
        return $val == 0 ? __('messages.Left to Right') : __('messages.Right to Left');
    }

}
