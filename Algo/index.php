<?php

/**
 * Pascal CESCON - FizzBuzz
 * 2022-08-03
 *
 * Instructions
 * ----------------------------------------------------------------------------
 * This is the very classical Fizz Buzz.
 *
 * Subject
 * ----------------------------------------------------------------------------
 * Display numbers between **1** and **N** by following the rules:
 *
 *  - if number can be divided by 3: display **Fizz** ;
 *  - if number can be divided by 5: display **Buzz** ;
 *  - if number can be divided by 3 **AND** 5 : display **FizzBuzz** ;
 *  - else: display the number.
 */


// I use a generator to deliver the results as soon as they are ready.
function run(int $limit): Generator {
    for ($i = 1; $i <= $limit; $i++) {
        if ($i % 3 == 0 && $i % 5 == 0) {
            yield "FizzBuzz\n";
        } elseif ($i % 3 == 0) {
            yield "Fizz\n";
        } elseif ($i % 5 == 0) {
            yield "Buzz\n";
        } else {
            yield $i . "\n";
        }
    }
}

// Initialize
$inputIsValid = false;
$input = fopen ("php://stdin","r");
$limit = 0;

const GREEN_COLOR = "\033[32m";
const RESET_COLOR = "\033[0m";
const RED_COLOR = "\033[31m";

// Getting a correct input
while (!$inputIsValid) {
    echo sprintf("%sWhat is your upper limit for the test ?\n%s", GREEN_COLOR, RESET_COLOR);
    $limit = fgets($input);
    if (is_numeric(trim($limit))) {
        $limit = (int) $limit;
        $inputIsValid = true;
    } else {
        echo sprintf("%sPlease enter a number (I can be patient)\n%s", RED_COLOR, RESET_COLOR);
    }
}

// running the test
echo sprintf("%sPlease fasten your seatbelt.\n%s", GREEN_COLOR, RESET_COLOR);
foreach (run($limit) as $line) {
    echo $line;
}