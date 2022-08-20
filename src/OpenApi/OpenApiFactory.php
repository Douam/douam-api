<?php

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\OpenApi;
use Symfony\Component\HttpFoundation\Request;

class OpenApiFactory implements OpenApiFactoryInterface 
{
    public function __construct(private OpenApiFactoryInterface $decorated)
    {
        
    }
    public function __invoke(array $context = []): OpenApi
    {
        $openapi = $this->decorated->__invoke($context);
        foreach($openapi->getPaths()->getPaths() as $key => $path){
            if ($path->getGet() && $path->getGet()->getSummary() === 'hidden'){
                $openapi->getPaths()->addPath($key, $path->withGet(null));
            }
        }

        $openapi->getPaths()->addPath('/ping', new PathItem(null, 'Ping',null, new Operation('ping-id', [], [], 'Reponse')));
        
        $schemas = $openapi->getComponents()->getSecuritySchemes();
        $schemas['cookieAuth'] = new \ArrayObject([
            'type' => 'apiKey',
            'in' => 'cookie',
            'name' => 'PHPSESSID'
        ]);
        //$openapi = $openapi->withSecurity(['cookieAuth' => []]);

        $schemas = $openapi->getComponents()->getSchemas();
        $schemas['creentials'] = new \ArrayObject([
            'type' => 'object',
            'porperties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'douam@gmail.fr'
                ],
                'password' => [
                    'type' => 'string'
                ]
            ]
        ]);

        $pathItem = new PathItem(
            post: new Operation(
                operationId: 'postApiLogin',
                tags: ['Auth'],
                requestBody: new RequestBody(
                    
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#components/schemas/Credentials'
                            ]
                        ]
                    ])
                ),
                responses: [
                    '200' => [
                        'description' => 'user connected',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#components/schemas/User-read.User'
                                ]
                            ]
                        ]
                    ]
                ]
            )
        );

        $openapi->getPaths()->addPath('/api/login', $pathItem);

        $pathItem = new PathItem(
            post: new Operation(
                operationId: 'postApiLogout',
                tags: ['Auth'],
                responses: [
                    '204' => [
                        
                    ]
                ]
            )
        );

        $openapi->getPaths()->addPath('/api/logout', $pathItem);
        return $openapi;
    
    }
}
