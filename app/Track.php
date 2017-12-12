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


    /**
     * Force format for start and end columns
     * @param $value
     */
    public function setStartAttribute($value) {
        $this->attributes['start'] = date('Y-m-d H:i:s',strtotime($value));
    }

    public function setEndAttribute($value) {
        if (!empty($value))
            $this->attributes['end'] = date('Y-m-d H:i:s',strtotime($value));
        else
            $this->attributes['end'] = null;
    }

}
