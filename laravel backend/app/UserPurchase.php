<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPurchase extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'uid','user_name', 'product_name', 'product_price'
    ];

}
