<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <script>
        // la promesse renvoie une valeur dans ce cas
        const promesse = new Promise((resolve, reject) => {

            // ici on aura une opération ASYNCHRONE qui consomme du temps.
            // Dans un example réel on aura un appel AJAX
            // L'opération doit être non-bloquante 
            // (ex: appel AJAX, setTimeout etc...)

            // juste pour montrer la syntaxe resolve et reject 
            // on va générer un résultat aléatoire
            // (random). Ce résultat doit venir de l'opération asynchrone (qu'on n'a pas lancé dans cet exemple théorique)
            let val = Math.floor(Math.random() * 2);
            if (val == 1) {
                resolve("tout ok");
            } else {
                reject("oh non!");
            }
        });


        // Syntaxe de base:
        // nomPromesse.then (onResolve, onReject)
        // ou
        // nomPromesse.then (onResolve)
        promesse
            .then(
                (resResolve) => {
                    console.log(resResolve);
                },
                (error) => {
                    console.log(error);
                });
        console.log("le code continue");

        // Syntaxe la plus utilisée:
        // nomPromesse.then (onResolve)
        promesse
            .then((resResolve) => {
                console.log(resResolve)
            });
    </script>

</body>

</html>