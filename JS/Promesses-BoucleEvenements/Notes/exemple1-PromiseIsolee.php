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
            // (ex: appel XHR, setTimeout etc...)

            // juste pour montrer resolve et reject 
            // on va générer un résultat aléatoire
            // (random)
            let val = Math.floor(Math.random() * 2);
            if (val == 1) {
                resolve("tout ok");
            } else {
                reject("oh non!");
            }
        });


        // Syntaxe: 
        // .then (onResolve, onReject)

        promesse
            .then(
                (resResolve) => {
                    console.log(resResolve);
                },
                (error) => {
                    console.log(error);
                });
        console.log ("le code continue");
    </script>

</body>

</html>