<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
   protected $fillable = [
      'name', 'email', 'address', 'joining_date', 'phone', 'salary', 'nid', 'photo'
   ];
}
