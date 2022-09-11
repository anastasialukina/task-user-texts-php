<?php
require 'vendor/autoload.php';

use App\Input;
use App\Output;

$inputUsers = new Input(';');
$users = $inputUsers->inputPeopleFile();
print_r($users);

$output = new Output;
$texts = $output->getTextFiles();
print_r($texts);