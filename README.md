facturesdevis
=============

A Symfony project created on August 9, 2019, 7:04 pm.


```
.-------------------------------------------------------------------------------.  
| .----------------------------------------------------------------------------.  |  
| |  _______     _________       __       ________    ____    ____  _________   | |  
| | |_   __ \   |_   ___  |     /  \     |_   ___ `. |_   \  /   _||_   ___  |  | |  
| |   | |__) |    | |_  \_|    / /\ \      | |   `. \  |   \/   |    | |_  \_|  | |  
| |   |  __ /     |  _|  _    / ____ \     | |    | |  | |\  /| |    |  _|  _   | |  
| |  _| |  \ \_  _| |___/ | _/ /    \ \_  _| |___.' / _| |_\/_| |_  _| |___/ |  | |  
| | |____| |___||_________||____|  |____||________.' |_____||_____||_________|  | |  
| |                                                                             | |  
| '-----------------------------------------------------------------------------' |  
 '-------------------------------------------------------------------------------'

```
     ## ** ------------------------------ ENGLISH -------------------------------:**
    
        ## **User instructions :**
        
        YOU CAN VISIT THE WEB SITE AT : http://cybix-tech.com/cinemovies/web/ 
            for admin access click on logo (c)
                        in the footer 
                        ex : (c) create by XXXXXXXX 
                        
                log : admin
                pwd : admin
        
         - _**Installation :**_
         Open a terminal, move to the folder where you want to clone the project, and copy the following lines of code
                   !! Make sure you have set up a recent version of GIT and COMPOSER !! :
               
         Check the server upload service ex: in local php.ini 
                post_max_size = 128M
                upload_max_filesize = 128M
                
        	1. ^$ git@github.com:juliengrima/cinemovies.git 
        	ou
        	2. ^$ git clone https://github.com/juliengrima/cinemovies.git`
        	3. ^$ cd cinemove
        	4. ^$ composer install 
        	        (follow instructions after composer's installation)
        	5. ^$ composer dump-autoload 
                    (fix bundles bug with Symfony 3.3.6)
        	6. ^$ php bin/console d:d:c 
        	        (create database)
        	7. ^$ php bin/console d:s:u --force
        	        (create tables in data base)
        	8. ^$ php bin/console a:i --symlink 
        	        (not obligatory PUBLIC is in web) 
            9. ^$ php bin/console fos:user:create adminuser --super-admin
                    (admin creation)
            10 In web/images repertory create 2 repertories (downloads / videos) 
            11 for admin access click on logo (c)
                    in the footer 
                    ex : (c) create by XXXXXXXX 
            12 In the navbar use logo + color green to create a new bouton          
                    and after create a category in dropdown
            13 Now you can insert a new movie 
              
        	
    
    ## when you create a bundle :
    
    Add in COMPOSER.JSON
    
    
        "autoload": { 
    
        "psr-4": { 
        ================================================================
        ---> "AppBundle\\": "src/AppBundle", 
             "BlogBundle\\": "src/BlogBundle", 
             "DemoBundle\\": "src/DemoBundle"
        ================================================================
    
        }, 
    
        "classmap": [ "app/AppKernel.php", "app/AppCache.php" ] },
        
    in terminal :  
    
        $ composer dump-autoload
    
    the bundle is active


    ## ** ---------------------------------- FRENCH --------------------------- :**

    ## **Instructions utilisateur :**
    
    VOUS POUVEZ VISITER LE SITE WEB A L'ADRESSE : http://cybix-tech.com/cinemovies/web/ 
        l'accès a l'administration il faut cliquer sur le logo (c)
                        dans le footer 
                        ex : (c) créé et géré par XXXXXXXX 
    
                    log : admin
                    pwd : admin
    
     - _**Installation :**_
     Ouvrez un terminal, déplacez-vous dans le dossier où vous souhaitez cloner le projet et copiez les lignes de code suivantes
      !! Assurez vous d'avoir paramètré une version récente de GIT et COMPOSER !! :
      
      checkez le serveur et son service d'upload 
      en local ex: php.ini 
                      post_max_size = 128M
                      upload_max_filesize = 128M
      
    	1. ^$ git@github.com:juliengrima/cinemovies.git 
    	ou
    	2. ^$ git clone https://github.com/juliengrima/cinemovies.git`
    	3. ^$ cd cinemove
    	4. ^$ composer install 
    	        (Suivez les instructions succédant l'installation du composer)
    	        (l'adresse mail est vivement recommandé pour FosUser)
    	5. ^$ composer dump-autoload 
                (Evite certain problèmes de bundles avec Symfony 3.3.6)
    	6. ^$ php bin/console d:d:c 
    	        (Création de la base de données)
    	7. ^$ php bin/console d:s:u --force
    	        (Enregistrement des tables dans la base de données)
    	8. ^$ php bin/console a:i --symlink 
    	        (Non obligatoire car le dossier PUBLIC est directement dans le web)
        9. ^$ php bin/console fos:user:create adminuser --super-admin
                (création de l'administrateur)
        10 Dans le repertoire web/images créer 2 repertoires (downloads / videos)
        
        11 Pour l'accès a l'administration il faut cliquer sur le logo (c)
                dans le footer 
                ex : (c) créé et géré par XXXXXXXX 
        12 Utiliser le bouton + de couleur verte pour creer un nouveau classement     
                puis avec le dropdown creer une categorie
        13 maintenant vous pouvez inserer de nouveaux film en fonction 
                du classement et des catégorie
    	

## Lors de la création d'un nouveau bundle:

Ajouter le namespace dans COMPOSER.JSON


    "autoload": { 

    "psr-4": { 
    ================================================================
    ---> "AppBundle\\": "src/AppBundle", 
         "BlogBundle\\": "src/BlogBundle", 
         "DemoBundle\\": "src/DemoBundle"
    ================================================================

    }, 

    "classmap": [ "app/AppKernel.php", "app/AppCache.php" ] },
    
Dans la console taper:  

    $ composer dump-autoload

Le Bundle est activé 


```
                               ,|     
                             //|                              ,|
                           //,/                             -~ |
                         // / |                         _-~   /  ,
                       /'/ / /                       _-~   _/_-~ |
                      ( ( / /'                   _ -~     _-~ ,/'
                       \~\/'/|             __--~~__--\ _-~  _/,
               ,,)))))));, \/~-_     __--~~  --~~  __/~  _-~ /
            __))))))))))))));,>/\   /        __--~~  \-~~ _-~
           -\(((((''''(((((((( >~\/     --~~   __--~' _-~ ~|
  --==//////((''  .     `)))))), /     ___---~~  ~~\~~__--~ 
          ))| @    ;-.     (((((/           __--~~~'~~/
          ( `|    /  )      )))/      ~~~~~__\__---~~__--~~--_
             |   |   |       (/      ---~~~/__-----~~  ,;::'  \         ,
             o_);   ;        /      ----~~/           \,-~~~\  |       /|
                   ;        (      ---~~/         `:::|      |;|      < >
                  |   _      `----~~~~'      /      `:|       \;\_____// 
            ______/\/~    |                 /        /         ~------~
          /~;;.____/;;'  /          ___----(   `;;;/               
         / //  _;______;'------~~~~~    |;;/\    /          
        //  | |                        /  |  \;;,\              
       (<_  | ;                      /',/-----'  _>
        \_| ||_                     //~;~~~~~~~~~ 
            `\_|                   (,~~ 
                                    \~\ 
                                     ~~ 
```

