<?php

session_start();
// db
require_once __DIR__ . '/db.php';

//dbh
require_once __DIR__ . '/database.php';

// class
require_once __DIR__ . '/class/DbObject.php';
require_once __DIR__ . '/class/ClassManager.php';

// db manager
require_once __DIR__ . '/class/DbManager.php';

$dbManager = new DbManager($db);

// utils
require_once __DIR__ . '/utils/errors.php';


$user = false;
if(isset($_SESSION['id'])){
    $user = $ddmanager->getById('users', $_SESSION['id'], 'UserForm');
    var_dump($user);
}
?>
