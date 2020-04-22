<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'client', 'client_addr', 'progress', 'deadline', 'total_price', 'description'];
}
