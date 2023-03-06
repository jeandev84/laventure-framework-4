<?php
namespace Laventure\Component\Routing\Contract;

use Laventure\Component\Routing\Route;

interface RouteDispatcherInterface
{
    /**
     * @param Route $route
     * @return mixed
    */
    public function dispatchRoute(Route $route);
}