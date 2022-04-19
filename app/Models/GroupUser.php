<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $table='group_user';
    protected $fillable=[
      'user_id','group_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
//
//    public function groups()
//    {
//        return $this->belongsToMany(Group::class,'groups','group_id');
//    }
}
