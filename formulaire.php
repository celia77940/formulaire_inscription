<?php 

session_start();

require_once('assets/require/connect.php');

if($_POST && $_FILES){
    var_dump($_POST);
    //Vérifie Si les champs ne sont pas vide
    if(isset($_POST['prenom']) && !empty($_POST['prenom'])
    && isset($_POST['nom']) && !empty($_POST['nom'])
    && isset($_POST['u_email']) && !empty($_POST['u_email'])
    && isset($_POST['u_password']) && !empty($_POST['u_password'])
    && isset($_FILES['photo']) && !empty($_FILES['photo'])){

    $prenom = strip_tags($_POST['prenom']);
    $nom = strip_tags($_POST['nom']);
    $u_email = strip_tags($_POST['u_email']);
    $u_password = sha1 (strip_tags($_POST['u_password']));

    //met dans la var le chemin ou je veux que le ticket soit save 
    $uploadchemin = 'assets/image/';
    // On insert dans la var $uploadfile le chemin plus nom du fichier envoyer dans la $_FILES
    $uploadfichier = $uploadchemin . basename($_FILES['photo']['name']);
    // Si le fichier télécharger n'est pas déplacé à l'endroit indiqué alors il sera déplacé
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfichier)){
        $_SESSION['erreurticket'] = "Il y'a eu un problème avec l'importation de la photo";

    }

    $sql = 'INSERT INTO inscription (prenom, nom, u_email, u_password, photo) VALUES (:prenom, :nom, :u_email, :u_password, :photo)';

    $query = $db->prepare($sql);

    $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $query->bindValue(':nom', $nom, PDO::PARAM_STR);
    $query->bindValue(':u_email', $u_email, PDO::PARAM_STR);
    $query->bindValue(':u_password', $u_password, PDO::PARAM_STR);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="prenom">Prenom</label>
            <input type="text" class="form-control" name="prenom" id="prenom" require>
        </div>
        <?php 
        $p = "/^[a-zA-Z-' ]*$/";

        if(isset($_POST['prenom'])){
            if(preg_match($p, $_POST['prenom'])){
                echo 'prenom correct';
            }else{
                echo 'prenom incorrect';
            }
        }
        ?>
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" id="nom">
        </div>
        <?php 

        if(isset($_POST['nom'])){
            if(preg_match($p, $_POST['nom'])){
                echo 'nom correct';
            }else{
                echo 'nom incorrect';
            }
        }
        ?>
        <div class="form-group">
            <label for="u_email">Email</label>
            <input type="email" class="form-control" name="u_email" id="u_email">
        </div>
        <div class="form-group">
            <label for="u_password">Password</label>
            <input type="password" class="form-control" name="u_password" id="u_password">
        </div>
        <div class="form-group">
            <label for="photo">photo</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
            <input type="file" class="form-control" name="photo" id="photo">
        </div>
        <button  type="submit" class="btn btn-dark">Inscription</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>
