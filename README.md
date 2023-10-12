**What's different about this Lib** :
This library has an implementation that allows you to configure a route without needing to specify a namespace. 
To do so, I implemented the SP Autoload feature that comes native in PHP. This way, you can define the Base Path 
for your controllers and proceed with route creation. The implementation of the custom autoload will take care of 
finding the controller class starting from the base path, considering the child folders.

**Observation** : These steps assume you are working on a Ubuntu system with Apache2. Adjustments might 
be needed for other operating systems or web servers.

**Examples** : In the library's installation folder, there are examples of .htaccess, controller, 
json of postman test examples, and an index file that will receive HTTP requests first and invoke 
the resources of the library
   

- To make it work on Apache, follow these steps:

    1 - Install by running the following command in the command line:
        
         Run the command:
                
                composer require sevencoder/router
        
    2 - To make it work on Apache2 on Ubuntu, for other operating systems, find equivalent commands.
            
            Run the command:
                
                sudo a2enmod rewrite

    3 - To take effect, restart Apache2 with the command:

            Run the command:
            
                sudo systemctl restart apache2
                
    4 - Configure a .htaccess file in a folder where it affects the relevant files. The content of the 
    .htaccess file should be:
    
            RewriteEngine On
            Options All -Indexes
            
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^(.*)$ index.php?route=$1 [L,QSA] 
            
    5 - Example of file that receive http request, configure router and call dispatch :
    
<pre>
```php
<?php

require 'vendor/autoload.php';

use SevenCoder\Router\Router;

/* this is the separator of class and method(of class controller) */
$separator = '@';

/* this is project url, you can define it here or get it from elsewhere */
$projectUrl = 'http://localhost/router';

$router = new Router($projectUrl, $separator);

/* base directory that get controller */
$baseDir = __DIR__.'/App/Controller';

/* set the base controller */
$router->setBasePath($baseDir);

$router->get('/', 'HomeController@helloWorld');
$router->get('test/{teste}/{teste2}', 'HomeController@testGet');
$router->post('test-post', 'HomeController@testPost');
$router->put('test-put', 'HomeController@testPut');
$router->patch('test-patch', 'HomeController@testPatch');
$router->options('test-options', 'HomeController@testOptions');
$router->delete('test-delete', 'HomeController@testDelete');

$router->prefix('test-prefix');
$router->get('1/{param1}/{param2}', 'HomeController@testGestPrefix');
$router->get('2', 'HomeController@testGetPrefix');

$router->dispatch();
```
</pre>
