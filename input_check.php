<?php
require 'vendor/autoload.php';

use App\Input;
use App\Commands;

$inputUsers = new Input(';');
$users = $inputUsers->inputPeopleFile();
print_r($users);

$commands = new Commands;
$texts = $commands->countAverageLineCount($users);
//print_r($texts);

$replaces = $commands->replaceDates();
$replacesWithNames = [];
foreach ($replaces as $key => $value) {
    $replacesWithNames[$users[$key]] = $value;
}
print_r($replacesWithNames);