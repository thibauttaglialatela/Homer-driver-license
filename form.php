<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de téléchargement de fichier</title>
    <style>
        main {
            width:50%;
            height:auto;
            background-color: palegoldenrod;
        }

        h1 {
            background-color: blue;
            color:aliceblue;
            text-align: center;
        }

        .informations {
            display:flex;
            justify-content: space-around;
        }
        .container {
            display:flex;
        }

        img {
            height:auto;
            width: 500px;
        }
    </style>
</head>
<body>
    <?php 
    if($_SERVER["REQUEST_METHOD"] === "POST" ){ 
       // Securité en php
    // chemin vers un dossier sur le serveur qui va recevoir les fichiers uploadés (attention ce dossier doit être accessible en écriture)
        $uploadDir = 'public/uploads/';
        
    // le nom de fichier sur le serveur est ici généré à partir du nom de fichier sur le poste du client (mais d'autre stratégies de nommage sont possibles)
        /* $uploadFile = $uploadDir . basename($_FILES['avatar']['name']); */
        $uploadFile = $uploadDir . uniqid("driver_"); //génération d'un nom de fichier unique
    // Je récupère l'extension du fichier
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    // Les extensions autorisées
        
        $extensions_ok = ['jpg','jpeg','png','webp'];
    // Le poids max géré par PHP par défaut est de 1M
        $maxFileSize = 1000000;
        $errors = [];
        if( (!in_array($extension, $extensions_ok ))){
            $errors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png ou webp !';
        }
    
        /****** On vérifie si l'image existe et si le poids est autorisé en octets *************/
        if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
        {
        $errors[] = "Votre fichier doit faire moins de 1M !";
        }

        if(!empty($errors)) {
            foreach($errors as $error) {
                echo $error . '<br>';
            }
        } else {
            // on déplace le fichier temporaire vers le nouvel emplacement sur le serveur. Ca y est, le fichier est uploadé
            $uploadFile .= '.' . $extension;
            move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
            header('location:/form.php');
        }


    
        
    }
    ?>

 
    <form action="" enctype="multipart/form-data" method="post">
        <label for="imageUpload">Upload your profile image</label>
        <input type="file" name="avatar" id="imageUpload">
        <button name="send">Send</button>
    </form>

    <main>
    <h1>SPRINGFIELD, IL</h1>
    <div class="informations">
        <h3>LICENCE#64209</h3>
        <h3>BIRTH DATE 4-24-56</h3>
        <h3>EXPIRES 4-24-2015</h3>
        <h3>CLASS NONE</h3>
    </div>

    <section class='container'>
        <img src="public/uploads/driver_61802c9869303.jpg" alt="ID_photo">
        <div class="information-container">
            <h2>HOMER SIMPSON</h2>
            <address>
                <h2>69 OLD PLUMTREE BLVD</h2>
                <h2>SPRINGFIELD, IL 62701</h2>
            </address>
        </div>
    </section>
    </main>    
    
</body>
</html>