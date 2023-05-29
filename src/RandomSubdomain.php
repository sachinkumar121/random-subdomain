<?php
namespace RandomSubdomain;

class RandomSubdomain {
    private $domain = null;
    private $path;
    private $noun = [];
    private $adjective = [];

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

    public function setPath($path) {
        $this->path = $path;
    }

    public function getPath() {
        return $this->path;
    }

    public function setDomain($domain) {
        $this->domain =  $domain;
        $this->path = $this->path.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$this->domain;
    }

    public function getDomain() {
        return $this->domain;
    }

    public function checkDomainExists(){
        if(file_exists($this->path)) {
           return true;
        }
        return false;
    }

    public function deleteDomain() {
        return $this->domainDir($this->path);
    }

    private function domainDir($dir){
        if (substr($dir, strlen($dir)-1, 1) != '/')
        $dir .= '/';

        if($handle = opendir($dir)){
            while ($obj = readdir($handle)){
                if ($obj != '.' && $obj != '..'){
                    if (is_dir($dir.$obj)){
                        if (!$this->domainDir($dir.$obj))
                            return false;
                    }elseif (is_file($dir.$obj)){
                        if (!unlink($dir.$obj))
                            return false;
                    }
                }
            }
            closedir($handle);
            if (!@rmdir($dir))
                return false;
            return true;
        }
        return false;
    }

    public function setNouns(array $list) {
        $this->noun = $this->path.DIRECTORY_SEPARATOR.'nouns.txt';
        file_put_contents($this->noun, implode("\n", $list));
    }

    public function setAdjectives(array $list) {
        $this->adjective = $this->path.DIRECTORY_SEPARATOR.'adjectives.txt';
        file_put_contents($this->adjective, implode("\n", $list));
    }

    public function getNouns($type = 'string', $forceCheck = false) {
        $file = $this->path.DIRECTORY_SEPARATOR.'nouns.txt';
        if(!file_exists($file)){
            $file = __DIR__.'/data/nouns.txt';
            $content = file_get_contents($file);
            if($forceCheck === true){
                return $type == 'array' ? [] : '';
            }
        }else{
            $content = file_get_contents($file);
            if(trim($content) == ''){
                if($forceCheck === true){
                    return $type == 'array' ? [] : '';
                }
                $path = __DIR__.'/data/nouns.txt';
                $content = file_get_contents($path);
            }
        }
        return $type == 'array' ? explode(PHP_EOL,$content) : $content;
    }

    public function getAdjectives($type = 'string', $forceCheck=false) {
        $file = $this->path.DIRECTORY_SEPARATOR.'adjectives.txt';
        if(!file_exists($file)){
            $file = __DIR__.'/data/adjectives.txt';
            $content = file_get_contents($file);
            if($forceCheck === true){
                return $type == 'array' ? [] : '';
            }
        }else{
            $content = file_get_contents($file);
            if(trim($content) == ''){
                if($forceCheck === true){
                    return $type == 'array' ? [] : '';
                }
                $path = __DIR__.'/data/adjectives.txt';
                $content = file_get_contents($path);
            }
        }
        return $type == 'array' ? explode(PHP_EOL,$content) : $content;
    }

    public function generateName(){
        $nounsLines = $this->getNouns('array');
        $adjectiveLines = $this->getAdjectives('array');

        $name = sprintf("%s-%s-%s",
            strtolower($nounsLines[$this->getRandomInt(0, count($nounsLines))]),
            strtolower($adjectiveLines[$this->getRandomInt(0, count($adjectiveLines))]),
            bin2hex(random_bytes(3))
        );
        return $name;
    }
    public function getUrl() {
        $name = $this->generateName();
        if($this->checkDomainExists()){
            $name .= trim($this->domain) ? '.'.$this->domain : '';
        }
        return $name;
    }

    public function getSuffixDomain() {
        $suffixDomain = $this->generateName();
        return $suffixDomain;
    }

    private function getRandomInt($min, $max){
        return floor(mt_rand() / mt_getrandmax() * ($max - $min)) + $min;
    }
}
