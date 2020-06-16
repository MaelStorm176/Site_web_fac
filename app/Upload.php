<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
    'filename','title','type','matiere'
  ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
