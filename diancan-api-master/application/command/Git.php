<?php

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;

class Git extends Command
{
    protected function configure()
    {
        $this->setName('git:pull')->setDescription('Here is the Git Pull');
    }

    protected function execute(Input $input, Output $output)
    {
        $base_path = dirname(dirname(__DIR__));
        exec('cd '.$base_path.' && git pull');
    }
}