environment
===========

`php environment.php`


```
    slava$ php environment.php

    [TEST]  Profile.dev/os.ini

    [OK]    osx

    [TEST]  Profile.dev/os/environment_osx.ini

    [OK]    php installed
    [OK]    php version
    [OK]    nodejs installed
    [FAIL]  nodejs version

            command : node -v
            version : 0.8.16
            regex : /(\d+\.\d+\.\d+)/

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

            class : Environment\Tester\Process

    [FAIL]  apache is working

            process : httpd
            command : ps -ef

            class : Environment\Tester\Process

    [FAIL]  mysql is working

            process : mysqld
            command : ps -ef

            class : Environment\Tester\Process

    [FAIL]  mongodb is working

            process : mongod
            command : ps -ef

            class : Environment\Tester\Process


    [SKIP]  ubuntu


    [FAIL]  Test(s) failed


```