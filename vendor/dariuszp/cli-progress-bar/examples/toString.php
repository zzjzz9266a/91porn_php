<?php

require_once('./../vendor/autoload.php');

use Dariuszp\CliProgressBar;

$bar = new CliProgressBar(10, 3);
print $bar . "\n";