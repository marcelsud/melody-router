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

    public function getRoutes() {
        return $this->routes;
    }

    public function get($name) {
        if (isset($this->routes[$name])) {
            return $this->routes[$name];
        }

        return false;
    }

    public function checkRoute($url, $route) {
        $rules = $this->definition->getRules();

        $segmentsToValidate = explode("/", trim($url, "/"));
        $patternSegments = explode("/", trim($route->getPattern(), "/"));

        if (count($segmentsToValidate) !== count($patternSegments)) {
            return false;
        }

        foreach($patternSegments as $key => $segment) {
            $valid = false;
            // TODO Throw exception if rule don't exists

            if ($segment == "*") {
                $valid = true;
            } elseif (isset($rules[$segment])) {
                $valid = $rules[$segment]($segmentsToValidate[$key]);
            } elseif ($segmentsToValidate[$key] == $patternSegments[$key]) {
                $valid = true;
            }

            if (!$valid) {
                break;
            }
        }

        if ($valid) {
            return $route;
        }

        return false;
    }

    public function match($url)
    {
        foreach ($this->routes as $route)
        {
            if ($url === $route->getPattern()) {
                return $route;
            }

            $matchedRoute = $this->checkRoute($url, $route);

            if ($matchedRoute) {
                return $matchedRoute;
            }
        }

        return false;
    }

}
