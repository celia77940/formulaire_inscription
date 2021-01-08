<?php 

session_start();



require_once('assets/require/connect.php');

if($_POST && $_FILES){
    var_dump($_POST);
    //Vérifie Si les champs ne sont pas vide
    if(isset($_POST['prenom']) && !empty($_POST['prenom'])
    && isset($_FILES['photo']) && !empty($_FILES['photo'])){

    $prenom = strip_tags($_POST['prenom']);

    //met dans la var le chemin ou je veux que le ticket soit save 
    $uploadchemin = 'assets/image/';
    // On insert dans la var $uploadfile le chemin plus nom du fichier envoyer dans la $_FILES
    $uploadfichier = $uploadchemin . basename($_FILES['photo']['name']<= MAX_SIZE);
    // Si le fichier télécharger n'est pas déplacé à l'endroit indiqué alors il sera déplacé
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfichier)){
        $_SESSION['erreurticket'] = "Il y'a eu un problème avec l'importation du ticket";

    }

    


    $sql = 'INSERT INTO inscription (prenom,photo) VALUES (:prenom, :photo)';

    $query = $db->prepare($sql);

    $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $query->bindValue(':photo', $uploadfichier, PDO::PARAM_STR);

    $query->execute();

    $_SESSION['message'] = "Success Votre Produit à été Ajouter avec succès";

    require_once('assets/require/close.php');

    }else{
        // On parametre le message d'erreur si les champs ne sont pas complet
        $_SESSION['erreur'] = "Il vous reste des champs à Remplir";
    }
}

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="prenom">Prenom</label>
            <input type="text" class="form-control" name="prenom" id="prenom">
        </div>
        <div class="form-group">
            <label for="photo">photo</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
            <input type="file" class="form-control" name="photo" id="photo">
        </div>
        <button  type="submit" class="btn btn-dark">Inscription</button></form>
    </body>
    </html>