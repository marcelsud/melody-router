<?php
namespace Melody\Router;

class RouteFactory
{
    public static function build($name = null, $pattern, array $parameters = null)
    {
        $route = new Route();
        $route->setName($name);
        $route->setPattern($pattern);
        $route->setParameters($parameters);

        return $route;
    }

}
