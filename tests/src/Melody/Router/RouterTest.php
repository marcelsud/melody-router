<?php

namespace Melody\Router;

use Melody\Router\Router;
use Melody\Router\Route;
use Melody\Router\Definitions\StandardDefinitionFactory;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    public function test_matching_string_route()
    {
        $name = "hello_world";
        $pattern = "/hello/(:str)/";
        $parameters = array(
                '_controller' => 'DefaultController',
                '_action' => 'indexAction',
                '_format' => 'html'
        );


        $router = new Router(StandardDefinitionFactory::build());
        $router->add(RouteFactory::build($name, $pattern, $parameters));

        $route = $router->match("/hello/world/");
        $this->assertInstanceof("Melody\Router\Route", $route);
        $this->assertEquals($name, $route->getName());
        $this->assertEquals($pattern, $route->getPattern());
        $this->assertEquals($parameters, $route->getParameters());
    }

    public function test_matching_alphanumeric_route()
    {
        $router = new Router(StandardDefinitionFactory::build());
        $router->add(RouteFactory::build("article", "/article/(:alpha)/"));

        $route = $router->match("/article/alphanumeric/");
        $this->assertInstanceof("Melody\Router\Route", $route);
    }

    public function test_matching_integer_route()
    {
        $router = new Router(StandardDefinitionFactory::build());
        $router->add(RouteFactory::build("product", "/product/(:int)/"));

        $route = $router->match("/product/1234/");
        $this->assertInstanceof("Melody\Router\Route", $route);
    }

    public function test_matching_slug_route()
    {
        $router = new Router(StandardDefinitionFactory::build());
        $router->add(RouteFactory::build("product", "/product/(:slug)/"));

        $route = $router->match("/product/test-this-slug/");
        $this->assertInstanceof("Melody\Router\Route", $route);
    }

    public function test_multi_segments_route() {
        $router = new Router(StandardDefinitionFactory::build());
        $router->add(RouteFactory::build("article", "/article/(:alpha)/(:int)/(:slug)"));
        $router->add(RouteFactory::build("product", "/product/(:alpha)/(:int)/(:slug)"));

        $routeProduct = $router->match("/product/ThisIsATest/1234/test-this-slug/");
        var_dump($routeProduct);
        die;
        $this->assertInstanceof("Melody\Router\Route", $routeProduct);
        $this->assertEquals("product", $routeProduct->getName());

        $routeArticle = $router->match("/article/ThisIsATest/1234/test-this-slug/");
        $this->assertInstanceof("Melody\Router\Route", $routeArticle);
        $this->assertEquals("article", $routeArticle->getName());
    }

    public function test_not_matching_route()
    {
        $router = new Router(StandardDefinitionFactory::build());
        $this->assertFalse($router->match("/hello/world/"));
    }

}

