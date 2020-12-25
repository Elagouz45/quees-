<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $table = 'systems';

    protected $fillable = [
        'service_time','interarrival_time','capacity','ti','M','n1','n2','n3','wq1','wq2','wq3'
    ];
}
