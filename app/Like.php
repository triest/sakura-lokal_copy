<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //
    protected $table = "likes";

    protected $fillable = ['who_id', 'target_id'];
}
