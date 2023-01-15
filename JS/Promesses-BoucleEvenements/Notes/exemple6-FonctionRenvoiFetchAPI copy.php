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

        fetch("./obtenirFilm.php?id=" + idFilm)
            .then(reponse => reponse.json()) // dans una arrow function: si un seul param, pas besoin de parenthéses. Si une seule instruction return, pas besoin des accolades
            .then((idGenre) => {
                return fetch("./obtenirTousFilmsGenre.php?idGenre=" + idGenre)
            })
            .then(reponse => reponse.json()) // dans una arrow function: si un seul param, pas besoin de parenthéses. Si une seule instruction return, pas besoin des accolades
            .then(res => console.log(res));
    </script>
</body>

</html>