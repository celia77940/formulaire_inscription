 <?php
//Essayer de ce connecter
//C'est une exception
try{
    // Connexion base de donnée
    $db = new PDO('mysql:host=127.0.0.1;dbname=exoinscription', 'root','');
    $db->exec('SET NAMES "UTF8"'); /* execute la Table de caractere */
/*Capture permet un message d'erreur si pas connecter et représente une erreur émise par PDO*/
}catch (PDOException $e){
    echo 'Erreur : '. $e->getMessage(); //récupere le message de l'exception
    die(); /*arreter l'execution du code*/
}