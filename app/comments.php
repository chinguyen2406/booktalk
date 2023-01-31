<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */

   
  public function user(){
    return $this->belongsTo('App\User');
  }
}
