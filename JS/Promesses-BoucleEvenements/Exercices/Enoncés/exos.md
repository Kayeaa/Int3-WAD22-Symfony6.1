## Pratique de base

L'API jsonplaceholder est un API est une api fake qui contient de données de base (chaque entrée "todo" contient un id et un text).
C'est une API utile pour nous car elle nous permet de réaliser toutes les actions d'une API:

- GET - obtenir de données
- POST - envoyér une donnée (ex: envoyer les données d'une commande dans une application d'e-commerce. Ce n'est pas nécessairement enregistré dans la BD)
- PUT - créer une donnée (ex: créer un produit dans une application d'e-commerce, il sera enregistré dans la BD)
- PATCH - modifier une partie d'une donnée dans le serveur (ex: modifier le prix d'un produit)
- DELETE - effacer une donnée

Voici le guide:

https://jsonplaceholder.typicode.com/guide/

Regardez la doc et pratiquez des appels en utilisant **fetch**.
Regardez aussi la section **Resources** ici : https\*\*://jsonplaceholder.typicode.com/

1. AFfichez trois photos choisies au hasard
2. Postez un nouveau commentaire et observez la réponse du serveur pour savoir si l'appel à été faite correctement
3. Obtenez tous les posts de l'utilisateur numéro 5. Affichez dans le DOM le nom de l'utilisateur et le contenu de chaque post
4. Effacez un user et observez la réponse du serveur pour savoir si l'appel à été faite correctement
5. Obtenez le nom de l'utilisateur qui a posté le post numéro 30. Attention car quand vous faites un appel à l'API pour obtenir un post où un user vous allez obtenir un array même s'il y a, par exemple, un seul post qui porte un id. Vous obtenez alors un array contenant un seul élément... mais c'est un array!

## Utilisation des APIs

En JS:

Pratiquez par vous-mêmes des appels fetch à des APIs qui ne demandent pas une key. Normalement vous allez faire des appels GET car vous ne pouvez pas modifier le contenu de la base de données du serveur. Voici une liste bien large!

https://mixedanalytics.com/blog/list-actually-free-open-no-auth-needed-apis/

En PHP avec Symfony:

Suivez cette doc:

https://symfony.com/doc/current/http_client.html#basic-usage

https://symfony.com/doc/current/http_client.html
