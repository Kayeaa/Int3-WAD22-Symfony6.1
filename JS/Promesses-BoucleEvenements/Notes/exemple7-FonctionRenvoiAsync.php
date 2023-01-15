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
        let idFilm = 1; // on le fixe, ça peut venir de n'importe où

        // on simplifie la fonction qui renvoie la promesse
        // avec async-await car on n'enchaîne pas avec then
        async function appelsAjax() {
            let response = await fetch("./obtenirFilm.php?id=" + idFilm);
            let idGenre = await response.json();
            response = await fetch("./obtenirTousFilmsGenre.php?idGenre=" + idGenre);
            let films = await response.json();
            console.log ( films);
        };

        appelsAjax();
        console.log ("je continue... sans attendre");


        
    </script>
</body>

</html>