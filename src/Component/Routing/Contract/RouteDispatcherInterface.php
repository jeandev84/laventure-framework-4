<?php
namespace Lexus\Component\Routing\Contract;

use Lexus\Component\Routing\Route;

interface RouteDispatcherInterface
{
    /**
     * @param Route $route
     * @return mixed
    */
    public function dispatchRoute(Route $route);
}