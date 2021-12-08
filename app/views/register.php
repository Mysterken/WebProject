<?php
//echo phpinfo();
$pdo = new PDO('mysql :host=localhost', 'route', 'example');

function str_random($length){
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

if(empty($errors)){


    // On enregistre les informations dans la base de données
    $req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?");
    // On ne sauvegardera pas le mot de passe en clair dans la base mais plutôt un hash
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    // On génère le token qui servira à la validation du compte
    $token = str_random(60);
    $req->execute([$_POST['username'], $password, $_POST['email'], $token]);
    $user_id = $pdo->lastInsertId();
    // On envoit l'email de confirmation
    mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://local.dev/Lab/Comptes/confirm.php?id=$user_id&token=$token");
    // On redirige l'utilisateur vers la page de login avec un message flash
    $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
    header('Location: login.php');
    exit();

}

$user_id = $_GET['id'];
$token = $_GET['token'];
require 'inc/db.php';
$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch();
session_start();

if($user && $user->confirmation_token == $token ){
    $pdo->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute([$user_id]);
    $_SESSION['flash']['success'] = 'Votre compte a bien été validé';
    $_SESSION['auth'] = $user;
    header('Location: account.php');
}else{
    $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
    header('Location: login.php');
}
if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
    require_once 'inc/db.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL');
    $req->execute(['username' => $_POST['username']]);
    $user = $req->fetch();
    if($user == null){
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrecte';
    }elseif(password_verify($_POST['password'], $user->password)){
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = 'Vous êtes maintenant connecté';
        header('Location: account.php');
        exit();
    }else{
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrecte';
    }
}


session_start();
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = 'Vous êtes maintenant déconnecté';
header('Location: login.php');

function logged_only(){
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION['auth'])){
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
        header('Location: login.php');
        exit();
    }
}

logged_only();
if(!empty($_POST)){

    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $_SESSION['flash']['danger'] = "Les mots de passes ne correspondent pas";
    }else{
        $user_id = $_SESSION['auth']->id;
        $password= password_hash($_POST['password'], PASSWORD_BCRYPT);
        require_once 'inc/db.php';
        $pdo->prepare('UPDATE users SET password = ? WHERE id = ?')->execute([$password,$user_id]);
        $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour";
    }

}

if(!empty($_POST) && !empty($_POST['email'])){
    require_once 'inc/db.php';
    require_once 'inc/functions.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL');
    $req->execute([$_POST['email']]);
    $user = $req->fetch();
    if($user){
        session_start();
        $reset_token = str_random(60);
        $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
        $_SESSION['flash']['success'] = 'Les instructions du rappel de mot de passe vous ont été envoyées par emails';
        mail($_POST['email'], 'Réinitiatilisation de votre mot de passe', "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\nhttp://local.dev/Lab/Comptes/reset.php?id={$user->id}&token=$reset_token");
        header('Location: login.php');
        exit();
    }else{
        $_SESSION['flash']['danger'] = 'Aucun compte ne correspond à cet adresse';
    }
}
if(isset($_GET['id']) && isset($_GET['token'])){
    require 'inc/db.php';
    require 'inc/functions.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
    $req->execute([$_GET['id'], $_GET['token']]);
    $user = $req->fetch();
    if($user){
        if(!empty($_POST)){
            if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']){
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $pdo->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL')->execute([$password]);
                session_start();
                $_SESSION['flash']['success'] = 'Votre mot de passe a bien été modifié';
                $_SESSION['auth'] = $user;
                header('Location: account.php');
                exit();
            }
        }
    }else{
        session_start();
        $_SESSION['flash']['error'] = "Ce token n'est pas valide";
        header('Location: login.php');
        exit();
    }
}else{
    header('Location: login.php');
    exit();
}