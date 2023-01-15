<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promises</title>
</head>

<body>
    <script>
        // exemples d'utilisation de l'API FETCH
        
        let idFilm = 1; // on le fixe, ça peut venir de n'importe où

        fetch("./obtenirFilm.php?id=" + idFilm)
            .then((reponse) => { // reponse est un objet de la class Reponse. Le then "lance" (consomme) la promesse fournie par .fetch
                return reponse.json(); // la méthode json() renvoie un objet de la classe Promise, pas une chaîne json. 
            })
            .then((res) => { // le then "lance" (consomme) la promesse fournie par .json. Dans son code interne, 
                // le "resolve" de cette promesse renvoie la chaîne (string) JSON
                console.log(res);
            });

        // le code simplifié (et le plus utilisé :D) serait:
        fetch("./obtenirFilm.php?id=" + idFilm)
            .then( reponse => reponse.json()) // dans una arrow function: si un seul param, pas besoin de parenthéses. Si une seule instruction return, pas besoin des accolades
            .then( res => console.log (res) // on est en train de faire un "return console.log (res)", mais ce n'est pas un problème
        );


        // à l'intérieur du code on aura quelque chose comme ci-dessous:
        //     const fetch = (url) => {
        //         .
        //         // code ajax....
        //         const promesse = new Promise ((resolve, reject) =>{
        //                    resolve (new Response (....))
        //         }
        //         .
        //         .
        //      }

        //     const json = (...) { // json est une méthode de l'objet Response
        //         .
        //         .
        //         const promesse = new Promise ((resolve, reject) =>{
        //             resolve (données) // resolve de la promesse 
        //                              // donnera du JSON
        //         
        //         }
        //         return promesse;
        //      }



       
    </script>
</body>

</html>