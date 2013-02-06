environment
===========

`php environment.php`


```
    slava$ php environment.php


    [TEST]  Profile/os.ini

    [OK]    osx

    [TEST]  Profile/os/environment_osx.ini

    [OK]    php installed
    [OK]    php version
    [OK]    nodejs installed
    [FAIL]  nodejs version

            command : node -v
            version : 0.8.16
            regex : /(\d+\.\d+\.\d+)/
            output : v0.8.14

            class : Environment\Tester\CommandVersion

    [OK]    mysql installed
    [OK]    mysql version
    [OK]    beanstalk installed
    [OK]    beanstalk version
    [OK]    phpunit installed
    [OK]    phpunit version
    [OK]    less installed
    [OK]    less version
    [FAIL]  beanstalk is working

            process : beanstalkd
            command : ps -ef
            output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 11:12A...

            class : Environment\Tester\Process

    [FAIL]  apache is working

            process : httpd
            command : ps -ef
            output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 11:12A...

            class : Environment\Tester\Process

    [FAIL]  mysql is working

            process : mysqld
            command : ps -ef
            output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 11:12A...

            class : Environment\Tester\Process

    [FAIL]  mongodb is working

            process : mongod
            command : ps -ef
            output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 11:12A...

            class : Environment\Tester\Process

    [FAIL]  apache is working on port

            ip : 127.0.0.1
            port : 80
            request : GET / HTTP/1.1\r\nHost: localhost\r\nConnection: Close\r\n\r\n
            response : apache
            output : Can not connect IP: 127.0.0.1 PORT: 80

            class : Environment\Tester\Socket

    [OK]    PDO extension
    [OK]    MB extension
    [OK]    current dir is writable
    [OK]    short_open_tag is empty
    [OK]    date.timezone is not empty

    [SKIP]  ubuntu


    [FAIL]  Test(s) failed


```