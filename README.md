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
            

        
    Observation : These steps assume you are working on a Ubuntu system with Apache2. Adjustments might 
    be needed for other operating systems or web servers.
    
    Examples : In the library's installation folder, there are examples of .htaccess, controller, 
    json of postman test examples, and an index file that will receive HTTP requests first and invoke 
    the resources of the library

