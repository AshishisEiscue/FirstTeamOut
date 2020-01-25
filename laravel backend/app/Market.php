<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =['image_url','product_name','product_price','product_description'];
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
     protected $guarded = ['id','created_at','updated_at'];
     
     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];
}
