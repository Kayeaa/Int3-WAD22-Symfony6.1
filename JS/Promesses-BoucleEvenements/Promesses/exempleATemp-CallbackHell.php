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
        // reformulation de l'appel AJAX. 
        // on reçoit un callback (quoi faire avec le résultat de l'appel AJAX)
        const appelAjax = (url, callback) => {

            var xhr = new XMLHttpRequest();
            xhr.open("GET", url);

            xhr.onreadystatechange = function() {
                // success: resolve
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let res = JSON.parse(xhr.responseText);
                    // on envoie le résultat au callback
                    callback(res);
                };
            }
            xhr.send();
        }


        // exemple base pour afficher juste le film
        idFilm = 1; // on le fixe, ça peut venir de n'importe où
        
        appelAjax("./obtenirFilm.php?id=" + idFilm, (resAjax) => {
            console.log (resAjax);
        });

        
        // obtenir tous le films du même genre que le film choisi.
        // mieux que l'exemple1 original, mais encore sujet au callback hell
        idFilm = 1; // on le fixe, ça peut venir de n'importe où
        appelAjax("./obtenirFilm.php?id=" + idFilm, (idGenre) => {
            appelAjax("./obtenirTousFilmsGenre.php?idGenre=" + idGenre, (result) => {
                console.log(result);
            })
        });

    </script>
</body>

</html>