# Boucle d'événements, exemples de base

<br>
Pour comprendre les promesses on doit d'abord avoir certains notions sur la boucle d'événements de JS.

La **boucle d'événements** (Event Loop en anglais) est un concept clé en JavaScript qui permet à l'exécution du code d'être gérée de manière asynchrone. Cela signifie que le code JavaScript peut continuer à s'exécuter même si des tâches longues ou des opérations de réseau sont en cours d'exécution.

Voici un exemple simple d'utilisation de la boucle d'événements :

```js
console.log("Début du script");

setTimeout(() => {
    console.log("Exécution d'une tâche longue");
}, 3000);

console.log("Fin du script");
```

Sortie: 

```
Début du script
Fin du script
Exécution d'une tâche longue
```

La fonction **setTimeout** est une fonction **asynchrone** qui **ajoute une tâche à la pile d'événements de la boucle d'événements**. Le temps indiqué est le temps **minimum** après lequel JS essayera de lancer le callback, mais ce temps **n'est pas garanti**. Le code sera lancé uniquement si il **n'y a rien dans la pile d'exécution**.

**Le code synchrone est ajouté à la pile d'exécution, les événements sont ajoutés à la pile d'événements. Aucun événement n'est lancé si la pile d'exécution n'est pas vide.**

Le moteur JS essaie de lancer setTimeout après trois secondes. Dans ce cas, l'execution se passe de cette manière:

1. lancer le prémier console.log
2. enregistrer le callback pour setTimeout
3. **continuer le code** et lancer l'autre console.log
4. après 3s. , le moteur regarde s'il n'y a rien dans la pile d'éxécution. Il n'y a rien, car le deuxième console.log a pris moins de 3s. pour s'executer.
Il prend le prémier (et seul, dans ce cas) événement de la pile d'événements et lance le callback associé (console.log ("Exécution...."))

Considérons un autre exemple:
 
```js

console.log("Début du script");
// on "enregistre" le setTimeout et on continue l'exécution du script (le for plus bas)
// le moteur js essaiera de lancer ce code dans 3 sec.
// il ne pas car la suite du code dure plus de 3 sec.
setTimeout(() => {
    console.log("Exécution d'une tâche longue");
}, 3000);

// operation qui prends longtemps, plus de 3 sec.
for (let i = 0; i < 10000000000; i++) {
    let val = i * 2;
}

console.log("Fin du script");

```

1. lancer le prémier console.log
2. enregistrer le callback pour setTimeout
3. **continuer le code** et lancer le for, **qui va prendre plein du temps**
4. après 3s. , le moteur regarde s'il n'y a rien dans la pile d'éxécution. Le for est toujours en train d'être exécuté, pas moyen de lancer le callback!
5. attendre la fin du for  
6. attendre l'exécution du dernier console.log. Fin du code, pile d'éxécution vide!
7. prendre le prémier et seul événement de la pile d'événements et lancer le callback ("Exécution....")
   

En gros on a deux taches longues, une asynchrone qui ne bloque pas le code (setTimeout) et une synchrone (la boucle) qui carrement bloque le code.
Quand le moment d'être lancé est arrivé pour la tâche asynchrone (setTimeout) elle doit **quand-même attendre** que la pile d'exécution soit vide.


## Callback Hell

<br>

**Callback Hell** est un terme utilisé pour décrire une situation où vous avez **des appels de retour imbriqués les uns dans les autres**, ce qui peut rendre le code difficile à lire et à maintenir. Voici un exemple de "Callback Hell" en utilisant du JavaScript vanilla:


```js
// Appel AJAX a une URL (peut-être une API ou une page dans notre propre app où, par exemple, on fait une requête à une BD)
// Ici on veut obtenir le genre d'un film (id=5) pour après obtenir 
// tous les films de ce genre. On doit faire deux appel AJAX
var xhr = new XMLHttpRequest();
xhr.open("GET", "obtenirGenreFilm.php?id=5");
xhr.onreadystatechange = function() {

    if (xhr.readyState === 4 && xhr.status === 200) {

        // résultat du premier appel AJAX ...
        let idGenre = JSON.parse(xhr.responseText);
        
        // ... qu'on utilise pour faire un autre appel AJAX!
        xhr = new XMLHttpRequest();
        xhr.open("GET", "obtenirTousFilmsGenre.php?id=" + idGenre);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {

                // résultat du deuxième appel
                let filmsGenre = JSON.parse(xhr.responseText);
            
                // si on veut utiliser ces données pour faire un autre appel
                // on commence à créer une structure pyramidale dont on ne
                // connait pas la fin: le callback hell
        

            }
        }
        xhr.send();
    }
};
xhr.send();
```

Voici une ré-formulation du callback hell où on peut voir encore plus claire la pyramide:

```js

// Fonction qui fait l'appel AJAX à une URL reçue
function getData(url, callback) {
    // Faire une requête AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            callback(JSON.parse(xhr.responseText)); // paramètre envoyée dans le callback plus bas
        }
    };
    xhr.send();
}
// Exemple base, tout va bien!
getData("https://example.com/obtenirGenreFilm.php?id=5", function(resultatAjax) {
    console.log (resultatAjax);
});



// Callback hell : Utiliser les données obtenues pour obtenir d'autres données
getData("https://example.com/page1.php", function(data1) {
    getData("https://example.com/page2.php?id=" + data1.id, function(data2) {
        getData("https://example.com/page3.php?id=" + data2.id, function(data3) {
            // Utiliser les données finales
            console.log(data3);
        });
    });
});
```

<br>

# Les Promesses : la solution

<br>

Une **promise** (promesse) est un objet qui: 

- **surveille la finalisation d’un certain événement asynchrone** (timer, AJAX, accès à une BD, etc…) dans l’application et
- **détermine quoi faire après cette finalisation** de l'action asynchrone
  

La promesse détermine quoi faire avec une valeur qu’on recevra dans le futur (ex: données d'une API, données d'un BD de la propre app...) et qui sera le résultat de l’événement.  

**Exemple :** demander la transformation d'une image qui se trouve dans le serveur. Quand l’image sera transformée et reçcue, une action sera réalisée (resolve). Si la demande échoue, une autre action sera lancée (reject) 

Une promese peut se trouver dans les états suivants : 

1. *Pending* - en attente
2. *Settled* - elle a fini son exécution et elle sera alors :
   
    a. **Resolved** - succes dans l’execution, résultat disponible

    b. **Rejected** - erreur dans l’execution, le résultat indisponible


<br>


## 1. Création, production et consommation d’une promesse

<br>

Nous allons voir la structure de base d’une promesse pour avoir un modèle général. On testera des exemples dans la section suivante. 
Pour utiliser une promesse, on doit la **créer** et la **consommer**: 

1. **Création** d’une promesse : le constructeur de la promesse reçoit une function, l’**executor**, qui lancera l’opération asynchrone à réaliser (AJAX, BD, etc…) et qui reçoit deux callbacks (resolve et reject). Observez le code:

```js
const obtenirFilm = new Promise ((resolve, reject) => {

    // lancer un code asynchrone (ex: appel AJAX)

    // si l'exécution est ok on fait appel à resolve
    resolve (résultat);

    // autrement on fait appel à reject
    reject(résultat);
    
})
```


2. **Consommer** (utiliser) une promesse : on lance la promesse et on attend le résultat de l’opération asynchrone pour l’utiliser dans…

        ◦ le callback resolve implémenté dans la section then
        ◦ le callback reject implémenté dans la section catch 


	
L’executor a deux paramètres callbacks : resolve et reject. Pendant la consommation de la promese (plus bas), le callback resolve sera appelé si l’opération à réaliser (obtenir image, données BD, etc… ) a été complétée avec succès. 
Autrement, le callback reject sera appelé. Toutes les deux méthodes reçoivent un paramètre qui contient le résultat de l’exécution de l’opération asynchrone. 
