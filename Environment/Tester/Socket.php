<?php
namespace Environment\Tester;

use Environment\Tester;
use Environment\TesterOutput;

class Socket extends Tester
{
    protected $defaults = array(
        'ip' => '127.0.0.1',
        'port' => '80',
        'request' => null,
        'response' => null,
        'regex' => null,
    );

    public function test()
    {

        /* Get the port for the WWW service. */
        $port = $this->get('port');
        $ip = $this->get('ip');

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$socket) {
            return false;
        }

        if (!@socket_connect($socket, $ip, $port)) {
            return false;
        }

        $request = $this->get('request');


        $request = str_replace('\r', "\r", $request);
        $request = str_replace('\n', "\n", $request);

        $response = '';

        socket_write($socket, $request, strlen($request));

        while ($out = socket_read($socket, 2048)) {
            $response .= $out;
        }

        socket_close($socket);

        $this->set('output', new TesterOutput($response));

        return $this->testResponse($response) || $this->testRegex($response);
    }

    public function testResponse($text){
      return !is_null($this->get('response')) && strpos(strtolower($text), strtolower($this->get('response'))) !== false;
    }

    public function testRegex($text){
        return !is_null($this->get('regex')) && preg_match($this->get('regex'), $text);
    }

}
