<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =['service_name','service_points','service_description'];
    
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


    /**
     * Get the post that owns the comment.
     */
    public function users()
    {
        return $this->belongsToMany('App\User','services_users','service_id','user_id');
    }
}
