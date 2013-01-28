<?php
namespace Melody\Router;

class RouteFactory
{
    public static function build($name = null, $pattern, array $parameters = null)
    {
        $compiledPattern = $pattern;

        $regex = array(
                '/\(:str\)/' => '([a-zA-Z]+)+|\/?',
                '/\(:int\)/' => '(\d+)+|\/?',
                '/\(:alpha\)/' => '([a-zA-Z0-9]+)+|\/?',
                '/\(:slug\)/' => '([a-z0-9-]+)+|\/?'
        );

        array_walk($regex, function($replacement, $pattern) use (&$compiledPattern) {
            $compiledPattern = preg_replace($pattern, $replacement, $compiledPattern);
        });

        $route = new Route();
        $route->setName($name);
        $route->setPattern($pattern);
        $route->setCompiledPattern($compiledPattern);
        $route->setParameters($parameters);

        return $route;
    }

}
