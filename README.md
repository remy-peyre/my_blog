#### Commands:

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"  

php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"  

php composer-setup.php  

php -r "unlink('composer-setup.php');"


#### Add file .sql in phpmyadmin


#### To create a admin:

U have to create an account with "remcos75" as username=>"pseudo"


#### Create a directory config, with a file config.yml  

 routes:  
     home: 'Default:home'  
     about: 'Default:about'  
     login: 'Security:login'  
     logout: 'Security:logout'  
     register: 'Security:register'  
     profil: 'Default:profil'  
     saison: 'Default:saison'  
     add_article: 'Article:add_article'  
     edit_article: 'Article:edit_article'  
     read_article: 'Default:read_article'  
     usersprofil: 'Default:usersprofil'  
     admin: 'Default:admin'  
     admin_user: 'Default:admin_user'  
     admin_article: 'Default:admin_article'   
     admin_comment: 'Default:admin_comment'  
     error:  'Default:error'
 
 defaut_route: 'home'
 
 db_config:  
     name: 'twd2'  
     host: 'localhost'  
     user: 'root'  
     pass: 'root'  