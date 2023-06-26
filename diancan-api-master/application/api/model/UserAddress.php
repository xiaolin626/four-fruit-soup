<?php

namespace app\api\model;

use think\Model;

class UserAddress extends BaseModel
{
   protected $hidden =[ 'delete_time', 'user_id'];

}


