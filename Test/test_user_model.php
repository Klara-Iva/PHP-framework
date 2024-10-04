<?php

require_once 'vendor\autoload.php'; 

use Src\Models\User;

$user = new User;
$user->first_name = 'Jack';
$user->last_name = 'Lantern';
$user->dob = '1997-06-14';
$array = $user->toArray();
$user->save();
$array = $user->toArray();
$user = User::find(1);
$user->dob = '2000-12-06';
$user->update();