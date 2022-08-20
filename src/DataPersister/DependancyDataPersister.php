<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Dependancy;
use App\Repository\DependancyRepository;

class DependancyDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(private DependancyRepository $repository)
    {
        
    }
  
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Dependancy;
         
    }

    public function persist($data, array $context = [])
    {
        $this->repository->persist($data);
    }
    public function remove($data, array $context = [])
    {

    }
}