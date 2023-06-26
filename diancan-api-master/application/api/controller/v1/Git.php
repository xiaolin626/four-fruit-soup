<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
class Git extends BaseController
{
    public function gitPull()
    {
        exec('php think git:pull');
    }
}