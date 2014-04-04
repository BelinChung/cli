<?php

namespace Pagon\Cli;

use Pagon\Route\Command;

class Route extends Command
{
    protected $arguments = array(
        'method' => array(
            'help' => 'Http Method'
        ),
        'path'   => array(
            'help' => 'Http path'
        )
    );

    public function run($req, $res)
    {
        $app = include($this->app->command['app_dir'] . '/bootstrap.php');

        $app->input = $mock_req = new \Pagon\Http\Input(array('app' => $app));
        $app->output = $mock_res = new \Pagon\Http\Output(array('app' => $app));
        $app->buffer = true;
        $app->cli = false;

        $mock_req->server['REQUEST_URI'] = $this->params['path'];
        $mock_req->server['REQUEST_METHOD'] = strtoupper($this->params['method']);
        $mock_req->server['REMOTE_ADDR'] = '127.0.0.1';
        $mock_req->server['SERVER_NAME'] = '127.0.0.1';
        $mock_req->server['SERVER_PORT'] = '80';
        $mock_req->server['SCRIPT_NAME'] = '/';

        include($this->app->command['public_dir'] . '/index.php');
    }
}