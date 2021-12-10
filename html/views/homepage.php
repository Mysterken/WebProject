<?php


use Html\Model\Users;

$user = new Users();
$user->setFirstName('bobby');
$user->setLastName('azaz');
$user->setEmail('azaz@livr.fr');
$user->setPassword('pass');
$user->setIsAdmin(0);

var_dump($user);
//$user->flush();
