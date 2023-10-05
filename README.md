para fazer funcionar no apache siga os seguintes passos

- Como fazer funcionar no apache2 no so ubuntu, em caso de outros SO, procura equivalencias nos comandos

1º Rode o comando : sudo a2enmod rewrite \
2º Para surtir efeito restart o apache2 com o comando : sudo systemctl restart apache2 \
3º configure um arquivos .htaccess em uma pasta aonde faça efeito nos arquivos de interesse, conteudo do .htaccess : \
RewriteEngine On
RewriteBase /

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?route=$1 [L,QSA]








