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

**La promesse détermine quoi faire avec une valeur qu’on recevra dans le futur** (ex: données d'une API, données d'un BD de la propre app...)  

**Exemple:** demander la transformation d'une image qui se trouve dans le serveur. Quand l’image sera transformée et reçue, une action sera réalisée (resolve). Si la demande échoue, une autre action sera lancée (reject) 

Une promese peut se trouver dans les états suivants : 

1. **Pending** - en attente, elle n'a pas finie son exécution
2. Si elle a fini son exécution et elle sera alors :

    a. **Resolved** - succes dans l’execution, résultat disponible

    b. **Rejected** - erreur dans l’execution, le résultat n'est pas disponible


<br>


## 1. Création, production et consommation d’une promesse

<br>

Nous allons voir la structure de base d’une promesse pour avoir un modèle général. On testera des exemples dans la section suivante. 
Pour utiliser une promesse, on doit la **créer** et la **consommer**: 

1. **Création** d’une promesse : le constructeur de la promesse reçoit une function, l’**executor**, qui lancera l’opération asynchrone à réaliser (AJAX, BD, etc…) et qui reçoit deux callbacks (resolve et reject). Observez le code:

```js
const obtenirFilm = new Promise ((resolve, reject) => {
    // ici il y aura un code qui prendra du temps
    // et qui renverra un résultat dans le cas de succés
    // et un autre différent dans le cas d'échec

    // si l'exécution est ok on fait appel à resolve
    if (...){
        resolve (resultatResolve);
    }
    // autrement on fait appel à reject
    else {
        reject(resultatReject);
    }
})
```
La fonction anonyme dans le constructeur est l'**executor**
L'appel à resolve renvoie la variable **resultatResolve**
L'appel à reject renvoie la variable **resultatReject**

**Resolve** et **reject** sont reçues en paramètres. C'est l'appel à la promesse ("consommer la promesse") qui envoie ces fonctions.


```js
obtenirFilm
.then ( 
    (resResolve) => {
        // faire quoi qui ce soit avec le résultat du success
        // de l'opération asynchrone    },
    (resReject) => {
        // faire quoi qui ce soit avec le résultat du échec 
        // de l'operation asynchrone
    }
);
```

On lance la consommation de la promesse quand on fait appel à **then**. La méthode **then** reçoit deux callbacks : **resolve** et **reject**. On n'est pas obligé de définir **reject** dans tous les cas.

Dans plein de cas on utilisera une syntaxe simplifié, sans **reject**:

```js
obtenirFilm
.then ( 
    (resResolve) => { 
        // code 
    }
);
```

ou encore plus simplifié si on fait que renvoyer une valeur : 

```js
obtenirFilm
.then ( 
    (resResolve) => valRetour
);
```

**Important**: **then** renvoie **toujours** une promesse. Si on fait juste **return** dans le code du then, la valeur de retour sera la valeur de la résolution de la promesse (resolve)

```js
.then ( val => val)
.then ( val => console.log (val) );
```

affichera **val**.


Si une erreur se produit pendant l'execution de la promesse on peut le capturer avec **catch**. Normalement on peut les capturer avec **reject** mais avec **catch** on peut couvrir le reste de cas. Si une erreur se produit dans le **then**, elle sera capturée par le catch.

obtenirFilm
.then ( 
    (resResolve) => {
        // faire quoi qui ce soit avec le résultat du success
        // de l'opération asynchrone    },
    (resReject) => {
        // faire quoi qui ce soit avec le résultat du échec 
        // de l'operation asynchrone
    }
)
.catch (
    (erreur) => {
        // faire quoi qui ce soit avec l'erreur
    }
)
;

<br>

## 2. API FETCH

<br>

**fetch()** est une méthode JavaScript standard qui permet de récupérer des données à partir d'une URL. Elle renvoie une promesse qui résout avec les données de la réponse de la requête HTTP. Vous pouvez utiliser cette méthode pour envoyer des requêtes HTTP et récupérer des données depuis un serveur, un fichier, ou toute autre source.

Voici quelques exemples d'utilisation de fetch() :

<br>

**1. Récupérer de données** (voir exemples 5 et 6 poour avoir des exemples complet)
```js
fetch('https://example.com/data')
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.log(error));
```

**2. Envoyer une requête POST avec des données en utilisant fetch()**


**Fetch** renvoie une promesse. Sa résolution nous donne un objet Response.
On peut enchaîner avec then et faire appel à la fonction response.json, qui renvoie à son tour une promesse. 
La résolution de cette promesse nous donnera le contenu json de cet objet Response (.json parcourt l'objet et extrait le contenu JSON).
On peut alors la résoudre et obtenir les données (ici "data") pour faire quoi qui ce soit.

Voici une requête GET :

```js
// URL de l'API OpenWeatherMap avec l'ID de la ville et la clé d'API
const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=Paris&appid=YOUR_API_KEY`;

// Utilisation de l'API fetch pour envoyer une requête à l'URL de l'API
fetch(apiUrl)
  .then(response => response.json()) // Parsage des données de réponse en JSON
  .then(data => {
    // Traitement des données récupérées
    console.log(data);
  })
  .catch(error => {
    // Gestion des erreurs de réseau
    console.error(error);
  });
```

Voici une requête POST :


```js
const data = { name: 'Marie', age: 35 };

fetch('https://example.com/submit', {
  method: 'POST',
  body: JSON.stringify(data),
  headers: { 'Content-Type': 'application/json' },
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.log(error)); // on peut produi
```

**fetch** ne gére pas les **reject** des promesses. Tout ce qu'on peut faire est créer un bloc try-catch pour capturer les exceptions. **fetch ne lance pas des exceptions pour les erreurs HTTP**, il les lance uniquement quand il y a une erreur de réseau: https://developer.mozilla.org/en-US/docs/Web/API/fetch#exceptions

On peut quand-même toujours faire le reject à la main dans notre code:

```js
fetch(url).then((response) => {
  if (// condition de notre réponse ok) {
    return response.json();
  }
  // on lance une exception ad-hoc
  throw new Error('Il y a eu un problème X');
})
.then((responseJson) => {
  // Do something with the response
})
.catch((error) => {
  console.log(error) // celle-ci capture uniquement les erreurs de réseau
});
```


<br>

## 3. ASYNC-AWAIT 


Une fonction **async** est une fonction JavaScript spéciale qui permet d'écrire des code asynchrone de manière plus simple et plus lisible, et permet l'utilisation d'await.

**await** est utilisé pour attendre la résolution d'une promesse avant de continuer l'exécution du code. Il ne peut être utilisé que dans une fonction dé déclaré avec async.

Une fonction async renvoie toujours une promesse qui résout avec ce qu'on met dans le return (si pas de return, la promesse résout à undefined).

**Notez que quand on fait appel à une function async, le reste du code continue son exécution.**
Une utilisation de base peut être :

```js
async function getData() {
    // l'attente se passe uniquement entre les 
    // appels asynchrones ici
    const response = await fetch('https://example.com/data');
    const data = await response.json();
    console.log(data);
    // la promesse résout à undefined
}

getData();
console.log ("on continue..."); // ce code se lance sans attendre!
``` 

Await ne bloque pas l'exécution du code, mais il permet de synchroniser l'exécution du code asynchrone.

Lorsque vous utilisez await pour attendre la fin d'une tâche asynchrone, le code qui suit l'instruction await ne s'exécute pas tant que la tâche asynchrone n'est pas terminée. Cela permet de synchroniser l'exécution du code avec la fin de la tâche asynchrone, mais cela ne bloque pas l'exécution d'autres tâches qui peuvent s'exécuter en parallèle.

En résumé, await ne bloque pas l'exécution du code, mais il permet de synchroniser l'exécution du code asynchrone. Il permet d'attendre la fin d'une tâche asynchrone avant de continuer à exécuter le code suivant, sans bloquer l'exécution d'autres tâches.

