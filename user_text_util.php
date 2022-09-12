<?php
require 'vendor/autoload.php';

use App\Input;
use App\Commands;

/*
*   first argument: comma or semicolon
*   second argument: countAverageLineCount or replaceDates
*   example command: php user_text_util.php comma countAverageLineCount
*/

if (count($argv) != 3) { //$argv[0] is always the name that was used to run the script
    die('Wrong amount of arguments. ' . 'Please write down command like this: ' .
        'php user_text_util.php comma countAverageLineCount');
} else {
    if ($argv[1] == 'comma') {
        $delimiter = ',';
    } else if ($argv[1] == 'semicolon') {
        $delimiter = ';';
    } else {
        die('Wrong first argument!');
    }
    $inputUsers = new Input($delimiter);
    try {
        $users = $inputUsers->inputPeopleFile();
    } catch (\Exception $e) {
        die($e->getMessage()); //it means, for example, our data from .csv does not match argument we passed
    }
    $commands = new Commands;
    if ($argv[2] == 'countAverageLineCount') {
        $averageLine = $commands->countAverageLineCount($users);
        print_r($averageLine);
    } else if ($argv[2] == 'replaceDates') {
        $replaces = $commands->replaceDates($users);
        print_r($replaces);
    } else {
        die('Wrong second argument!');
    }
}