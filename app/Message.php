<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $guarded = [];

    public function fromContact()
    {
        return $this->hasOne(User::class, 'id', 'from');
    }

    public function toContact()
    {
        return $this->hasOne(User::class, 'id', 'to');
    }
}
