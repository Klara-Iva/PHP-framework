<?php

require_once 'vendor\autoload.php'; 

use Src\Models\User;

$user = new User;
$user->first_name = 'Jack';
$user->last_name = 'Lantern';
$user->birthday = '1997-06-14';
$array = $user->toArray();
$user->save();
$user = new User;
$user->first_name = 'Johnny';
$user->last_name = 'Dracula';
$user->birthday = '2000-02-09';
$array = $user->toArray();
$user->save();