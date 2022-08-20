<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource(
    itemOperations: ['get'],
    collectionOperations: ['get'],
    paginationEnabled: false
)]

class Dependancy
{
    #[ApiProperty(
        identifier: true
    )]

    private string $uuid;

    #[ApiProperty(
        description: 'Dependancy name'
    )]

    private string $name;
    #[ApiProperty(
        description: 'Dependancy version'
    )]
    private string $version;

    public function __construct(
        string $name, string $version
        )
    {
        $this->name = $name;
        $this->version = $version;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

}