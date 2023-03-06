<?php
namespace Laventure\Component\Routing;

use Laventure\Component\Routing\Contract\RouteDispatcherInterface;

class RouteDispatcher implements RouteDispatcherInterface
{

    /**
     * @inheritDoc
    */
    public function dispatchRoute(Route $route)
    {
          if (! $route->callable()) {
              $controller = $route->getController();
              $action     = $route->getAction();
              $route->callback([new $controller, $action]);
          }

          return $route->call();
    }
}