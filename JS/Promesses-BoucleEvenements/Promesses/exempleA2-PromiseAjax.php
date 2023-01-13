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
        // on n'envoie pas un callback! on définira quoi faire avec le 
        // résultat de l'appel AJAX plus tard

        // La fonction appelAjax n'utilise pas le résultat 
        // de l'appel AJAX elle même en appellant un callback

        // appelAJAX crée et renvoie un promesse qui: 
        // - fait l'appel AJAX 
        // - fixe les résultats por resolve (succés) et reject (échec)
        // resolve et reject sont définies plus tard (then y catch)

        const appelAjax = (url) => {

            // crée et envoie une promesse, consommée à l'extérieur
            const promesseAjax = new Promise((resolve, reject) => {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", url);
                xhr.onreadystatechange = function() {
                    // success: resolve
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        let res = JSON.parse(xhr.responseText);
                        // ok! on appel "resolve" et on lui envoie le résultat obtenu 
                        // avec AJAX à la fonction
                        // Resolve est un callback reçu en paramètre et défini 
                        // au moment de consommer la promesse (section 'then')
                        resolve(res);
                        // Observez la différence: ici on n'est pas en train de définir "quoi faire"
                        // car on n'a pas défini encore le callback resolve.
                        // On va le faire quand on consomme la promesse
                    };
                    if (xhr.status != 200) {
                        // erreur : reject. On peut utiliser le résultat 
                        // quand on consomme la promesse (section 'catch')
                        reject("error ajax");
                    }
                }
                xhr.send();
            });
            // renvoie la promesse
            return promesseAjax;
        }

        // exemple base pour afficher juste le film
        let idFilm = 1; // on le fixe, ça peut venir de n'importe où

        // consommation de la promesse!
        appelAjax("./obtenirFilm.php?id=" + idFilm)
            .then((resAjax) => { // le then est lancé si on fait appel à resolve
                console.log(resAjax);
            })
            .catch((res) => { // le catch est lancé si on fait appel à reject
                console.log("erreur!");
            });


        // obtenir tous le films du même genre que le film choisi.
        // mieux que l'exemple1 original, mais encore sujet au callback hell

        // consommation de la promesse. Callback hell eliminé
        appelAjax("./obtenirFilm.php?id=" + idFilm)
            .then((idGenre) => {
                return appelAjax("./obtenirTousFilmsGenre.php?idGenre=" + idGenre);
                // cette nouvel appel renvoie une promesse aussi, je peux enchainer avec then
            })
            .then((res) => {
                console.log(res);
                // ou un autre appelAjax qui aura son .then en bas...
                // return appelAjax("./uneAutreAction.php?id=" + ...);

            })
        // .then((resX) => {
        //     console.log(resX);
        // })
        // .then ()
        // .then ()
        // .then .....
        // .catch((resultatReject) => {
        //     console.log(resultatReject);
        // });
    </script>
</body>

</html>