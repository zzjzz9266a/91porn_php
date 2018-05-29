<?php

require_once('./../vendor/autoload.php');

use Dariuszp\CliProgressBar;

$bar = new CliProgressBar(48);
$bar->display();

$bar->setColorToRed();

while($bar->getCurrentstep() < $bar->getSteps()) {
    usleep(50000);
    $bar->progress();

    if ($bar->getCurrentstep() >= ($bar->getSteps() / 2)) {
        $bar->setColorToYellow();
    }
}

$bar->setColorToGreen();
$bar->display();

$bar->end();