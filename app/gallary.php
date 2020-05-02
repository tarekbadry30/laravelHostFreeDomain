<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gallary extends Model
{
    protected $guarded = [];
    protected $fillable=["post_id","img_url",];
}
