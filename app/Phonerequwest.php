<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phonerequwest extends Model
{
    //
    protected $table = 'phone_requwest';

    protected $fillable = ['who_id', 'target_id','readed','status','who_name','image','created_at','updated_at'];
}
