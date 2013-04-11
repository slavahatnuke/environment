Hat Environment
===========
The lib allows to check your environment easy and allows to test and build your environment in one action

`bin/environment`

```
    slava$ bin/environment
    
    [SKIP]      --default
    [SKIP]      --dev
    
    [OK]        environment.ini

```




```


    [OK]        --default
    
    [SKIP]      ubuntu
    [OK]        osx
    
    [FAIL]      php version
    
                    definition : php version
    
                    properties :
                      command : php -v
                      version : 5.4.0
    
    
                    options :
                      name : php version
                      class : Hat\Environment\Tester\CommandVersion
    
    
                    result :
                      command : php -v
                      version : 5.4.0
                      regex : /(\d+\.\d+\.\d+)/
                      output : PHP 5.3.18 (cli) (built: Nov 24 2012 14:53:21)Copyright (c) 1997-2012 The PHP Gr...
    
    
    [OK]        nodejs installed
    [FAIL]      nodejs version
    
                    definition : nodejs version
    
                    properties :
                      command : node -v
                      version : 0.8.16
    
    
                    options :
                      name : nodejs version
                      class : Hat\Environment\Tester\CommandVersion
                      depends : nodejs installed
    
    
                    result :
                      command : node -v
                      version : 0.8.16
                      regex : /(\d+\.\d+\.\d+)/
                      output : v0.8.14
    
    
    [OK]        mysql installed
    [OK]        mysql version
    [OK]        beanstalk installed
    [OK]        beanstalk version
    [OK]        less installed
    [OK]        less version
    [OK]        mongo installed
    [OK]        mongo version
    [OK]        phpunit installed
    [OK]        phpunit version
    [FAIL]      beanstalk is working
    
                    definition : beanstalk is working
    
                    properties :
                      process : beanstalkd
    
    
                    options :
                      name : beanstalk is working
                      class : Hat\Environment\Tester\Process
                      depends : beanstalk installed
    
    
                    result :
                      process : beanstalkd
                      command : ps -ef
                      output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 10:15A...
    
    
    [FAIL]      mysql is working
    
                    definition : mysql is working
    
                    properties :
                      process : mysqld
    
    
                    options :
                      name : mysql is working
                      class : Hat\Environment\Tester\Process
                      depends : mysql installed
    
    
                    result :
                      process : mysqld
                      command : ps -ef
                      output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 10:15A...
    
    
    [FAIL]      mongodb is working
    
                    definition : mongodb is working
    
                    properties :
                      process : mongod
    
    
                    options :
                      name : mongodb is working
                      class : Hat\Environment\Tester\Process
    
    
                    result :
                      process : mongod
                      command : ps -ef
                      output :   UID   PID  PPID   C STIME   TTY           TIME CMD    0     1     0   0 10:15A...
    
    
    [OK]        http server is working
    [OK]        PHP PDO extension
    [OK]        PHP MB extension
    [FAIL]      PHP.ini short_open_tag is empty
    
                    definition : PHP.ini short_open_tag is empty
    
                    properties :
                      option : short_open_tag
                      expected : 0
    
    
                    options :
                      name : PHP.ini short_open_tag is empty
                      class : Hat\Environment\Tester\PhpIni
    
    
                    result :
                      option : short_open_tag
                      expected : 0
                      output :
    
    
    [OK]        PHP.ini date.timezone is not empty
    [FAIL]      app cache is writable
    
                    definition : app cache is writable
    
                    properties :
                      path : app/cache
    
    
                    options :
                      name : app cache is writable
                      class : Hat\Environment\Tester\IsWritable
    
    
                    result :
                      path : app/cache
    
    
    [OK]        ebadmin cache is writable
    [OK]        app logs is writable
    [OK]        ebadmin logs is writable
    
    [FAIL]      osx
    
    [FAIL]      --default
    [SKIP]      --dev
    
    [FAIL]      environment.ini

```

Install via Composer
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

`environment.ini` should be in the root of your project
you can see example `vendor/hat/environment/environment.ini`
 