<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
	
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }	
}
