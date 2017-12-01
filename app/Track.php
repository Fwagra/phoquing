<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $guarded = [];

    public function setTotalAttribute($value)
    {
        if (!empty($this->attributes['end'])) {
            $this->attributes['total'] = totalCalculation(strtotime($this->attributes['start']), strtotime($this->attributes['end']));
        }
    }

}
