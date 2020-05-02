<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reply extends Model
{
    protected $guarded = [];
    protected $fillable=["user_id","comment_id","com_content",];
}
