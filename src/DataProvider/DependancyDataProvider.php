<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Dependancy;
use App\Repository\DependancyRepository;

class DependancyDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface, ItemDataProviderInterface
{

    public function __construct(private DependancyRepository $repository)
    {

    }
    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        return $this->repository->findAll();       
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Dependancy::class;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        return $this->repository->find($id);
    }

    private function getDependancies(): array
    {
        $path = $this->rootPath . '/commposer.json';
        $json = json_decode(file_get_contents($path), true);
        return $json;       
    }

}