<?php

namespace app\admin\controller;

use think\Db;

class Index extends Base
{
    public function index()
    {
        return view('index');
    }
	public function dindex()
	{
	    return view('dindex');
	}

    public function main()
    {
        $version = Db::query('SELECT VERSION() AS ver');
        $config = [
            'url'            => request()->domain(),
            'document_root'  => $_SERVER['DOCUMENT_ROOT'],
            'server_os'      => PHP_OS,
            'server_port'    => $_SERVER['SERVER_PORT'],
            'server_ip'      => $_SERVER['SERVER_ADDR'],
            'server_soft'    => $_SERVER['SERVER_SOFTWARE'],
            'php_version'    => PHP_VERSION,
            'mysql_version'  => $version[0]['ver'],
            'max_upload_size' => ini_get('upload_max_filesize')
        ];
        $data = db('system')->find(1);
        $this->assign('config', $config);
        $this->assign('data', $data);
        return view('main');
    }

}