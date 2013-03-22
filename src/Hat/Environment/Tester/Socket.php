<?php
namespace Hat\Environment\Tester;

use Hat\Environment\Tester;
use Hat\Environment\TesterOutput;
use Hat\Environment\Exception;

class Socket extends Tester
{
    protected $defaults = array(
        'ip' => '127.0.0.1',
        'host' => null,
        'port' => '80',
        'request' => null,
        'response' => null,
        'regex' => null,
    );

    public function test()
    {

        $port = $this->get('port');
        $ip = $this->get('ip');
        $host = $this->get('host');

        if (!is_null($host)) {
            $ip = gethostbyname($host);
        }

        if (!function_exists('socket_create')) {
            throw new Exception('no function: socket_create');
        }

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$socket) {
            $this->set('output', 'Can not create a socket');

            return false;
        }

        if (!@socket_connect($socket, $ip, $port)) {
            $this->set('output', "Can not connect IP: {$ip} PORT: {$port}");

            return false;
        }

        $request = $this->get('request');


        if (!is_null($request)) {
            $request = str_replace('\r', "\r", $request);
            $request = str_replace('\n', "\n", $request);

            $response = '';

            socket_write($socket, $request, strlen($request));

            while ($out = socket_read($socket, 2048)) {
                $response .= $out;
            }

            $this->set('output', new TesterOutput($response));

            socket_close($socket);

            return $this->testResponse($response) || $this->testRegex($response);
        }

        socket_close($socket);

        return true;

    }

    public function testResponse($text)
    {
        return !is_null($this->get('response')) && strpos(
            strtolower($text),
            strtolower($this->get('response'))
        ) !== false;
    }

    public function testRegex($text)
    {
        return !is_null($this->get('regex')) && preg_match($this->get('regex'), $text);
    }

}
