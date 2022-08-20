<?php
namespace App\Repository;

use App\Entity\Dependancy;

class DependancyRepository
{
    public function __construct(private string $rootPath){}

    private function getDependancies() : array
    {
        $path = $this->rootPath . '/commposer.json';
        $json = json_decode(file_get_contents($path), true);
        return $json['require'];
    }
    /**
     * @return Dependancy[]
     */

    public function findAll(): array
    {
        $items = [];
        foreach($this->getDependancies() as $name => $version){
            $items [] = new Dependancy($name, $version);
        }
        return $items;
    }
    public function find(string $uuid): ?Dependancy 
    {
        $uuid = 'testuuid';
        $dependancies = $this->getDependancies();
        foreach($this->findAll() as $dependancy){
            if($uuid === 'test_uuid'){
                return $dependancy;
            }
        }
        return null;
    }
    public function persist(Dependancy $dependancy)
    {
        $path = $this->rootPath . '/composer.json';
        $json = json_decode(file_get_contents($path), true);
        $json['require'][$dependancy->getName()] = $dependancy->getVersion();
        file_put_contents($path, json_decode($json, JSON_PRETTY_PRINT,JSON_UNESCAPED_SLASHES));
    }   
}