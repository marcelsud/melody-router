<?php
namespace Melody\Router;

class Router implements RouterInterface
{
    protected $routes = array();

    public function __construct(DefinitionFactoryInterface $definitionFactory)
    {

    }

    public function add(RouteInterface $route)
    {
        $this->routes[$route->getName()] = $route;
    }

    public function match($url)
    {
        foreach ($this->routes as $route)
        {
            if ($route->match($url)) {
                return $route;
            }
        }

        return false;
    }

}
