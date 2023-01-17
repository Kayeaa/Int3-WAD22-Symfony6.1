# Installation

```
composer require symfony/messenger
```

1. Créer le message
2. Créer le handler
3. Configurer le transport
4. Envoyer un message dans un service où un controller (il faut injecter le MessageBus)


# Avantages d'utiliser Messenger

1. Séparation des responsabilités

Le composant Messenger permet de séparer la logique de traitement des messages de la logique métier. Cela signifie que vous pouvez écrire des handlers pour traiter les messages sans avoir à vous soucier de la logique métier de l'application.

2. Traitement asynchrone
   
Le composant Messenger prend en charge le traitement asynchrone des messages. Cela signifie que vous pouvez envoyer un message sur le bus de message et continuer à exécuter d'autres tâches sans attendre que le message soit traité. Cela peut améliorer les performances de l'application en évitant les blocages inutiles.


3. Scalabilité
   
Le composant Messenger prend en charge plusieurs transports, comme les files d'attente, les bases de données ou les sockets, ce qui vous permet de choisir le transport qui convient le mieux à vos besoins et de scaler facilement en fonction de la charge de travail.

4. Flexibilité 
   
Le composant Messenger permet de créer des workflows de traitement de message complexe en enchainant des handlers, en utilisant des middleware, etc. Il est également possible de définir des règles de routage pour rediriger les messages vers les handlers appropriés.

5. Intégration avec d'autres composants

Le composant Messenger est étroitement lié aux autres composants de Symfony, tels que les événements, les commandes, les tâches planifiées, etc. Il est donc facile de l'intégrer dans une application existante qui utilise déjà ces composants.

6. Sécurité 

Le composant Messenger permet de sécuriser les messages en utilisant des bus sécurisés, et de s'assurer que seul les handlers autorisés peuvent traiter les messages.

Ces avantages font de Messenger un outil puissant pour construire des applications robustes, évolutives et fiables.