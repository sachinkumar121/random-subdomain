<?php
namespace RandomSubdomain;

class RandomSubdomain {
    private $domain = null;
    private $path;

    public function __construct($domain = null, $path = __DIR__) {
        $this->domain = $domain;
        $this->path = $path;
        if ($this->domain) {
            $this->createDir();
        }
    }

    private function createDir() {
        $this->path = $this->path.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$this->domain;
        
        if(!file_exists($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }

    private function getPath() {
        return $this->path;
    }

    private function getDomain() {
        return $this->domain;
    }

    public function setNouns($csv) {
        $file = $this->getPath().DIRECTORY_SEPARATOR.'nouns.txt';
        file_put_contents($file, $csv);
    }

    public function setAdjectives($csv) {
        $file = $this->getPath().DIRECTORY_SEPARATOR.'adjectives.txt';
        file_put_contents($file, $csv);
    }

    public function getNouns() {
        $file = $this->getPath().DIRECTORY_SEPARATOR.'nouns.txt';
        return file_get_contents($file);
    }

    public function getAdjectives() {
        $file = $this->getPath().DIRECTORY_SEPARATOR.'adjectives.txt';
        return file_get_contents($file);
    }

    public function getRandomSiteUrl() {
        $nouns = $this->getNouns();
        $adjective = $this->getAdjectives();
        $domain = $this->getDomain();

        $nounsLines = explode(',', $nouns);
        $adjectiveLines = explode(',', $adjective);

        $name = $nounsLines[$this->getRandomInt(0, count($nounsLines))]
                .'-'.
                $adjectiveLines[$this->getRandomInt(0, count($adjectiveLines))]
                .'-'.
                bin2hex(random_bytes(2)) . ".$domain";
        
        return $name;
    }

    private function getRandomInt($min, $max)
    {
        return floor(mt_rand() / mt_getrandmax() * ($max - $min)) + $min;
    }
}
