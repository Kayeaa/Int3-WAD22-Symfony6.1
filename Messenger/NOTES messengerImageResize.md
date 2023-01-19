# Messenger 

https://symfony.com/doc/current/messenger.html

Messenger permet de **gérer des tâches asynchrones** dans une application Symfony. 
Cela permet d'améliorer les performances de l'application en évitant les temps d'attente inutiles. 


<br>

## Exemple pratique*

<br>

Considérez un site qui permet d'uploader une photo de profil. L'utilisateur choisit la photo mais le serveur doit la traiter - changer la taille - pour éviter un gaspillage innécessaire de resources.
Considérez cette séquence :

**1**. L'utilisateur soumet le form avec l'image

**2**. Le controller reçoit le formulaire

**3**. Le controller fait appel à un service d'upload, tout ok

**4**. Le controller traite l'image

**5**. Le controller envoie une réponse au client (nouvelle page, message etc...)

Nous devons faire face à un possible problème: le traitement de l'image peut prendre du temps (ça serait encore pire si on devait traiter un fichier d'audio ou vidéo).
Pendant tout ce temps du traitement, l'utilisateur **devra attendre sans obtenir aucune réponse du serveur**! car 
l'éxécution de notre controller est **synchrone**.
**Messenger** est la solution car il va nous **permettre de lancer la tâche de traitement ()

Nous allons faire le code pour gérer cette situation!
On créera un controller qui affichera un formulaire d'upload pour uploader des images de pays. L'image será stocké dans le serveur après l'avoir reduite.
Le traitement se fera de façon **asynchrone**: l'utilisateur recevra la réponse "upload ok" sans devoir attendre le traitement de l'image.

On sait que le traitement se fera vraiment très vite. Pour pouvoir apprecier l'asynchronicité on mettra un sleep dans la fonction du traitement... on 
pourra voir que le client reçoit quand-même la réponse sans devoir attendre!

Allons-y!

<br>

## Procedure

<br>

Créez un projet ProjetMessenger (si vous ne l'avez pas encore).

    Nous allons utiliser du code déjà fait du ProjetFormulaires. Tout le code se trouve quand-même dans le repo (projetMessenger)
    Copiez l'entité Pays ainsi que son repository et son formulaire PaysType du ProjetFormulairesSymfony
    Copiez le template qui affiche le formulaire d'upload du ProjetFormulairesSymfony
    Copiez le service d'upload et configurer le paramètre pour le dossier de services.yaml tel qu'il se trouve dans ProjetFormulaires
    Faites la migration


## 1. Installez Messenger et Intervention (pour manipuler l'image)

<br>

```
composer require symfony/messenger
composer require intervention/image
```


Dans **services.yaml**, assurez-vous d'avoir mis le paramètre pour configurer l'emplacement des uploads

```yaml
services:
    # default configuration for services in *this* file
    _defaults:
        autowire: true      # Automatically injects dependencies in your services.
        autoconfigure: true # Automatically registers your services as commands, event subscribers, etc.
        bind:
            $dossierUpload: '%kernel.project_dir%/public/uploads'
```



## Créer le Message ResizeImage




## Créer le handler

## Configurar le transport

## Créer le service

## Créer le controller

Pour consommer les messages, on lance le **worker**:

```
php bin/console messenger:consume async -vv
```

messenger.yaml : rajouter             reset_on_message: true


Dans services.yaml on doit rajouter ImageManager comme service:

    # add more service definitions when explicit configuration is needed
    # please note that last definitions always *replace* previous ones
    Intervention\Image\ImageManager:
