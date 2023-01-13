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
        // exemple d'enchaînement sans promesse
        const somme = (v1, v2) => {
            return v1 + v2;
        }
        const mult = (v1, v2) => {
            return v1 * v2;
        }
        const div = (v1, v2) => {
            return v1 / v2;
        }

        const calculatrice = (v1, v2, callback) => {
            return callback(v1, v2);
        }

        // tout ok
        console.log ("exemple appel simple:");
        console.log (calculatrice(5, 5, somme));
        

        // on va faire maintenant 100 / ( 2 * (20 + 5) )  
        // callback hell !!
        console.log ("exemple appel chaîne:");
        console.log(
            calculatrice(100,
                calculatrice(2,
                    calculatrice(20, 5, somme),
                    mult),
                div)
        );


        // exemple d'enchaînement avec promesses
        console.log("exemple promesse"); 

        // cette fonction reçoit les deux valeurs pour opérer et l'opération (callback)
        // MAIS elle ne renvoie pas le résultat des opérations: elle crée et renvoie une promesse
        // pour laquelle elle a défini le résultat du resolve 
        const calculatriceP = (v1, v2, callback) => {
            const promesse = new Promise((resolve, reject) => {
                resolve(callback(v1, v2));
            });
            return promesse;
        }

        // au revoir callback hell! pas de code pyramide mais vertical
        // à chaque then on reçoit une promesse auquelle on peut appliquer la fonction .then à nouveau
        calculatriceP(20, 5, somme)
            .then((res) => {
                return (calculatriceP (2, res,  mult));
            })
            .then ((res) => {
                return (calculatriceP (100, res, div))
            })
            .then ((res) => {
                console.log (res);
            })
        
    </script>

</body>

</html>