Hat Environment
===========
The lib allows to check your environment easy

`bin/environment`

```

    slava$ bin/environment

    [TEST]  environment.ini

    [SKIP]  --install
    [SKIP]  --clear
    [SKIP]  --dev
    [SKIP]  --live


    [OK]    Test(s) passed

```



Test project for --dev environment
===================

```

    slava$ bin/environment --dev
    
    [TEST]  environment.ini
    
    [SKIP]  --install
    [SKIP]  --clear
    [OK]    --dev
    
    [TEST]  ./profile/dev/os.ini
    
    [OK]    osx
    
    [TEST]  ./profile/dev/os/environment_osx.ini
    
    [OK]    php installed
    [OK]    php version is 5.3.10 or great
    [OK]    php version must not be 5.3.16 as Symfony 2 will not work properly with it
    [OK]    node must be installed
    [FAIL]  nodejs version
    
            definition : nodejs version
    
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
    
            definition : beanstalk is working
    
            process : beanstalkd
            command : ps -ef
            output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 11:44P...
    
            class : Hat\Environment\Tester\Process
    
    [FAIL]  mysql is working
    
            definition : mysql is working
    
            process : mysqld
            command : ps -ef
            output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 11:44P...
    
            class : Hat\Environment\Tester\Process
    
    [FAIL]  mongodb is working
    
            definition : mongodb is working
    
            process : mongod
            command : ps -ef
            output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 11:44P...
    
            class : Hat\Environment\Tester\Process
    
    [FAIL]  apache is working
    
            definition : apache is working
    
            process : apache2
            command : ps -ef
            output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 11:44P...
    
            class : Hat\Environment\Tester\Process
    
    [FAIL]  apache is working on port
    
            definition : apache is working on port
    
            ip : 127.0.0.1
            port : 80
            output : Can not connect IP: 127.0.0.1 PORT: 80
    
            class : Hat\Environment\Tester\Socket
    
    [FAIL]  apache answer on request
    
            definition : apache answer on request
    
            ip : 127.0.0.1
            port : 80
            request : GET / HTTP/1.1\r\nHost: localhost\r\nConnection: Close\r\n\r\n
            response : apache
            output : Can not connect IP: 127.0.0.1 PORT: 80
    
            class : Hat\Environment\Tester\Socket
    
    [OK]    PDO extension
    [OK]    MB extension
    [OK]    current dir is writable
    [OK]    short_open_tag is empty
    [OK]    date.timezone is not empty
    [OK]    os.ini contains os name darwin
    [OK]    os.ini contains os name darwin with regex
    
    [SKIP]  ubuntu
    [SKIP]  debian
    [SKIP]  fedora
    
    [SKIP]  --live
    
    
    [FAIL]  Test(s) failed

```

Test project --live environment
==================

```

    slava$ bin/environment --live
    
    [TEST]  environment.ini
    
    [SKIP]  --install
    [SKIP]  --clear
    [SKIP]  --dev
    [OK]    --live
    
    [TEST]  ./profile/default/os.ini
    
    [OK]    osx
    
    [TEST]  ./profile/default/os/environment_osx.ini
    
    [OK]    php installed
    [OK]    php version is 5.3.10 or great
    [OK]    php version must not be 5.3.16 as Symfony 2 will not work properly with it
    [OK]    node must be installed
    [FAIL]  nodejs version
    
            definition : nodejs version
    
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
    
            definition : beanstalk is working
    
            process : beanstalkd
            command : ps -ef
            output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 11:44P...
    
            class : Hat\Environment\Tester\Process
    
    [FAIL]  mysql is working
    
            definition : mysql is working
    
            process : mysqld
            command : ps -ef
            output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 11:44P...
    
            class : Hat\Environment\Tester\Process
    
    [FAIL]  mongodb is working
    
            definition : mongodb is working
    
            process : mongod
            command : ps -ef
            output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 11:44P...
    
            class : Hat\Environment\Tester\Process
    
    [FAIL]  apache is working
    
            definition : apache is working
    
            process : httpd
            command : ps -ef
            output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 11:44P...
    
            class : Hat\Environment\Tester\Process
    
    [FAIL]  apache is working on port
    
            definition : apache is working on port
    
            ip : 127.0.0.1
            port : 80
            output : Can not connect IP: 127.0.0.1 PORT: 80
    
            class : Hat\Environment\Tester\Socket
    
    [FAIL]  apache answer on request
    
            definition : apache answer on request
    
            ip : 127.0.0.1
            port : 80
            request : GET / HTTP/1.1\r\nHost: localhost\r\nConnection: Close\r\n\r\n
            response : apache
            output : Can not connect IP: 127.0.0.1 PORT: 80
    
            class : Hat\Environment\Tester\Socket
    
    [OK]    PDO extension
    [OK]    MB extension
    [OK]    current dir is writable
    [OK]    short_open_tag is empty
    [OK]    date.timezone is not empty
    [OK]    os.ini contains os name darwin
    [OK]    os.ini contains os name darwin with regex
    
    [SKIP]  ubuntu
    [SKIP]  debian
    [SKIP]  fedora
    
    
    
    [FAIL]  Test(s) failed

```

Install and test project
=============
```

    slava$ bin/environment --install
    
    [TEST]  environment.ini
    
    [OK]    --install
    
    [TEST]  ./profile/install/os.ini
    
    [OK]    osx
    
    [TEST]  ./profile/install/os/environment_osx.ini
    
    [OK]    git installed
    [FAIL]  git clone
    [BUILD] git clone
    
            git clone git://github.com/slavahatnuke/environment.git profile/install/tmp/environment-project
    remote: Counting objects: 594, done.
    remote: Compressing objects: 100% (322/322), done.
    remote: Total 594 (delta 301), reused 492 (delta 199)
    Receiving objects: 100% (594/594), 68.69 KiB, done.
    Resolving deltas: 100% (301/301), done.
    
    [OK]    git clone
    [OK]    curl installed
    [OK]    php version is 5.3.10 or great
    [FAIL]  copmposer installed
    [BUILD] copmposer install
    
            curl -s https://getcomposer.org/installer | php -- --install-dir=profile/install/tmp/environment-project
    
    [OK]    copmposer installed
    [OK]    project installed
    [BUILD] change directory
    
            dir: profile/install/tmp/environment-project
    
    [BUILD] install composer packages
    
            php composer.phar install
    
    [BUILD] test installed project
    
            php environment.php --dev
    
    
            definition : test installed project
    
            command : php environment.php --dev
            output : [TEST]  environment.ini[SKIP]  --install[SKIP]  --clear[OK]    --dev[TEST]  ./pr...
    
            class : Hat\Environment\Builder\ExecuteCommand
    
    
    [SKIP]  ubuntu
    [SKIP]  debian
    [SKIP]  fedora
    
    [SKIP]  --clear
    [SKIP]  --dev
    [SKIP]  --live
    
    
    [FAIL]  Test(s) failed

```


Clear project
====================
```

    bin/environment --clear
    
    [TEST]  environment.ini
    
    [SKIP]  --install
    [OK]    --clear
    
    [TEST]  ./profile/clear/os.ini
    
    [OK]    osx
    
    [TEST]  ./profile/clear/os/environment_osx.ini
    
    [FAIL]  project is not installed
    [BUILD] remove project directory
    
            rm -rf ./profile/install/tmp/environment-project
    
    [OK]    project is not installed
    
    [SKIP]  ubuntu
    [SKIP]  debian
    [SKIP]  fedora
    
    [SKIP]  --dev
    [SKIP]  --live
    
    
    [OK]    Test(s) passed

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

`vendor/hat/environment/bin/environment --profile=vendor/hat/environment/environment.ini --dev`