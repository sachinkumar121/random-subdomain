<?php
// Including the autoloader.
include __DIR__.'/../vendor/autoload.php';
// Importing the classes.
use RandomSubdomain\RandomSubdomain;
$randomSubdomain = new RandomSubdomain('a.instawpsites.com');
echo $url = $randomSubdomain->getUrl();
$domainName = 'abc.example.com';
$csvNoun = ['abc','def'];
$csvAdjective = ['jkl','xyz'];
$randomSubdomain = new RandomSubdomain($domainName, $path);
$randomSubdomain->setNouns($csvNoun);
$randomSubdomain->setAdjectives($csvAdjective);
$url = $randomSubdomain->getUrl();
echo $url;