<?php
namespace Laventure\Component\Routing\Resource;


class WebResource extends Resource
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
                'methods' => ['GET'],
                'path'    => '/create',
                'action'  => 'create'
            ],
            [
                'methods' => ['POST'],
                'path'    => '/store',
                'action'  => 'store'
            ],
            [
                'methods' => ['GET'],
                'path'    => '/{param}/edit',
                'action'  => 'edit'
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
         return 'web';
    }
}