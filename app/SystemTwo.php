<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemTwo extends Model
{
    protected $table = "system_twos";
    protected $fillable = [
        'arrive_rate','service_rate','capacity','servers','p','Po','Pn','L','Lq','W','Wq'
    ];
}
