<?php
// Including the autoloader.
include __DIR__.'/../vendor/autoload.php';

// Importing the classes.
use RandomSubdomain\RandomSubdomain;

$randomSubdomain = new RandomSubdomain('a.instawpsites.com');
echo $url = $randomSubdomain->getRandomSiteUrl();
die;

$domainName = 'abc.example.com';
$path = "/Library/WebServer/Documents/instawp-random-name-generator";
$csvNoun = 'abc,def';
$csvAdjective = 'jkl,xyz';

$randomSubdomain = new RandomSubdomain($domainName, $path);
$randomSubdomain->setNouns($csvNoun);
$randomSubdomain->setAdjectives($csvAdjective);

echo $url = $randomSubdomain->getRandomSiteUrl();
die;