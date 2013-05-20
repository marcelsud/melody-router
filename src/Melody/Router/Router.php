<?php
namespace Melody\Router;

use Melody\Router\Definitions\DefinitionInterface;

class Router implements RouterInterface
{
    protected $routes;
    protected $definition;

    public function __construct(DefinitionInterface $definition)
    {
        $this->definition = $definition;
        $this->routes = array();
    }

    public function add(RouteInterface $route)
    {
        $this->routes[$route->getName()] = $route;
    }

    public function match($url)
    {
        foreach ($this->routes as $route)
        {
            $valid = true;
            $rules = $this->definition->getRules();

            $segmentsToValidate = explode("/", trim($url, "/"));
            $patternSegments = explode("/", trim($route->getPattern(), "/"));

            if (count($segmentsToValidate) > 0) {
                foreach($segmentsToValidate as $key => $segment) {
                    if (isset($rules[$segment])) {
                        $valid = $rules[$segment]($segment[$key]);
                    } elseif ($segmentsToValidate[$key] == $patternSegments[$key]){
                        $valid = true;
                    }

                    if (!$valid) {
                        return false;
                    }
                }

                if ($valid) {
                    return $route;
                }
            }

            return $valid;
        }

        return false;
    }

}
