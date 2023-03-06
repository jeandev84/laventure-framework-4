<?php
namespace Laventure\Component\Routing\Resource;

class ApiResource extends Resource
{

    /**
     * @inheritDoc
    */
    protected static function configureRoutes(): array
    {
        return [
            [
                'methods' => ['GET'],
                'path'    => '/',
                'action'  => 'index'
            ],
            [
                'methods' => ['GET'],
                'path'    => '/{param}',
                'action'  => 'show'
            ],
            [
                'methods' => ['POST'],
                'path'    => '/store',
                'action'  => 'store'
            ],
            [
                'methods' => ['PUT'],
                'path'    => '/{param}',
                'action'  => 'update'
            ],
            [
                'methods' => ['DELETE'],
                'path'    => '/{param}',
                'action'  => 'destroy'
            ]
        ];
    }



    /**
     * @inheritDoc
    */
    public function getResourceType(): string
    {
         return 'api';
    }
}