Hat Environment
===========
The lib allows to check your environment easy

`php environment.php` or

`php environment.php --profile=Profile.dev/os.ini`


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

            class : Hat\Environment\Tester\CommandVersion

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

            class : Hat\Environment\Tester\Process

    [FAIL]  mysql is working

            process : mysqld
            command : ps -ef
            output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 11:12A...

            class : Hat\Environment\Tester\Process

    [FAIL]  mongodb is working

            process : mongod
            command : ps -ef
            output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 11:12A...

            class : Hat\Environment\Tester\Process

    [OK]    apache is working
    [OK]    apache is working on port
    [OK]    apache answer on request
    [OK]    PDO extension
    [OK]    MB extension
    [OK]    current dir is writable
    [OK]    short_open_tag is empty
    [OK]    date.timezone is not empty
    [OK]    os.ini contains os name darwin
    [OK]    os.ini contains os name darwin with regex

    [SKIP]  ubuntu


    [FAIL]  Test(s) failed

```

Installation via Composer
===========

`curl -s https://getcomposer.org/installer | php`

`subl composer.json`

```

    {
        "require": {
            "hat/environment": "dev-master"
        }
    }

```

`php composer.phar install`

you can test default profile

`php vendor/hat/environment/environment.php --profile=vendor/hat/environment/Profile/os.ini`