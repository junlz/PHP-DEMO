<?php

require './event.php';

class Server
{
    public $ip = '';

    public $port = 80;

    public $path = "./pid.txt";

    public $event;

    public static function daemon()
    {
        umask(0); 

        $pid = pcntl_fork();

        if ($pid) {
            exit(0); 
        } elseif ($pid < 0) {
            die("fork failed\n");
        }

        $sid = posix_setsid(); 

        $pid = pcntl_fork();

        if ($pid) {
            exit(0); 
        } elseif ($pid < 0) {
            die("fork failed\n");
        }

        if ($sid < 0) {
            die("create session failed\n");
        }
    }

    public function __construct($ip, $port = 80)
    {
        $this->ip = $ip;
        $this->port = $port;
        $this->event = new MyEvent();
    }

    public function run()
    {
        if ($GLOBALS['argc'] > 1) {
            $this->sendSignal();
            exit(0);
        } else {
            self::daemon();
        }

        $this->installSignalHandler();
        $this->recordPid();
        $this->start();
    }

    public function sendSignal()
    {
        //检查服务器是否存活
        if (posix_kill($this->getPid(), 0)) {
            if (strpos($GLOBALS['argv'][1], "stop") !== false) {
                posix_kill($this->getPid(), SIGUSR1);
            }
        }
    }

    public function start()
    {
        $domain = sprintf("tcp://%s:%d", $this->ip, $this->port);

        $fd = stream_socket_server($domain, $errno, $errstr);

        if (!$fd) {
            die("$errno $errstr\n");
        }

        stream_set_blocking($fd, 0);

        $this->event->add($fd, Event::READ | Event::PERSIST, [$this, 'requestHandler'], $fd);

        $this->event->loop();
    }

    public function requestHandler($fd)
    {
        $conn = stream_socket_accept($fd);

        fwrite($conn, "HTTP/1.0 200 OK\r\nContent-Length: 2\r\n\r\nHi");
        fclose($conn);
    }

    public function installSignalHandler()
    {
        $this->event->add(SIGUSR1, Event::SIGNAL, [$this, "handler"], SIGUSR1);
    }

    public function handler($signo)
    {
        switch($signo) {
            default:
            case SIGUSR1:
                $this->event->remove($signo);
                $this->stop();
                break;
        }
    }

    public function stop()
    {
        exit(0);
    }

    public function getPid()
    {
        return file_get_contents($this->path);
    }

    private function recordPid()
    {
        file_put_contents($this->path, posix_getpid());
    }
}

$server = new Server("127.0.0.1");

$server->run();
