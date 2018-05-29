<?php

require_once('./../vendor/autoload.php');

use Dariuszp\CliProgressBar;

$bar = new CliProgressBar(10, 3);

print("THIS WILL NOT WORK UNDER WINDOWS (PROBABLY)\n\n");

print("BLACK\n");
$bar->setColorToBlack();
$bar->display();
$bar->end();

print("\nRED\n");
$bar->setColorToRed();
$bar->display();
$bar->end();

print("\nGREEN\n");
$bar->setColorToGreen();
$bar->display();
$bar->end();

print("\nYELLOW\n");
$bar->setColorToYellow();
$bar->display();
$bar->end();

print("\nBLUE\n\n");
$bar->setColorToBlue();
$bar->display();
$bar->end();

print("\nMAGENTA\n\n");
$bar->setColorToMagenta();
$bar->display();
$bar->end();

print("\nCYAN\n\n");
$bar->setColorToCyan();
$bar->display();
$bar->end();

print("\nWHITE\n\n");
$bar->setColorToWhite();
$bar->display();
$bar->end();

print("\nDEFAULT\n\n");
$bar->setColorToDefault();
$bar->display();
$bar->end();

print("\nDONE!\n\n");