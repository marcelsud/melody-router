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

    private function checkRoute($url, $route) {
        $segmentsToValidate = explode("/", trim($url, "/"));
        $patternSegments = explode("/", trim($route->getPattern(), "/"));

        if (count($segmentsToValidate) !== count($patternSegments)) {
            return false;
        }

        foreach($patternSegments as $key => $segment) {
            $valid = false;
            $valid = $this->assert($segmentsToValidate[$key], $segment, $route);

            if (!$valid) {
                break;
            }
        }

        if (isset($valid) && $valid) {
            return $route;
        }

        return false;
    }

    private function assert($input, $rule, RouteInterface $route)
    {
        $parameters = $route->getParameters();

        if ($input == $rule) {
            return true;
        }

        if (preg_match('/^{(.*?)}$/', $rule, $matches)) {
            if (isset($parameters['requirements'][$matches[1]]) && $this->validate($input, $parameters['requirements'][$matches[1]])) {
                $route->addInput($matches[1], $input);

                return true;
            }
        }

        return false;
    }

    private function validate($input, $rule)
    {
        if ($this->definition->exists($rule)) {
            return $this->definition->rules[$rule]($input);
        }

        return false;
    }

}
