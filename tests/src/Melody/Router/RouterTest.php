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

        $route = $router->match("/article/alpha/");
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

        $productRoute = $router->match("/product/alpha/1234/test-this-slug/");
        $this->assertInstanceof("Melody\Router\Route", $productRoute);
        $this->assertEquals("product", $productRoute->getName());

        $articleRoute = $router->match("/article/alpha/1234/test-this-slug/");
        $this->assertInstanceof("Melody\Router\Route", $articleRoute);
        $this->assertEquals("article", $articleRoute->getName());
    }

    public function test_route_alnum_rule() {
        $router = new Router(StandardDefinitionFactory::build());
        $router->add(RouteFactory::build("article", "/article/(:alnum)/"));

        $articleRoute = $router->match("/article/alphanumeric1234/");
        $this->assertInstanceof("Melody\Router\Route", $articleRoute);
        $this->assertEquals("article", $articleRoute->getName());
    }

    public function test_route_any_rule() {
        $router = new Router(StandardDefinitionFactory::build());
        $router->add(RouteFactory::build("article", "/article/*/"));

        $articleRoute = $router->match("/article/daodeijjir30daidaikrq393qpfakdaij2o34ij4iife-1231-/");
        $this->assertInstanceof("Melody\Router\Route", $articleRoute);
        $this->assertEquals("article", $articleRoute->getName());
    }

    public function test_no_segments_route() {
        $router = new Router(StandardDefinitionFactory::build());
        $router->add(RouteFactory::build("home", "/"));

        $homeRoute = $router->match("/");
        $this->assertEquals("home", $homeRoute->getName());
    }

    public function test_not_matching_route()
    {
        $router = new Router(StandardDefinitionFactory::build());
        $router->add(RouteFactory::build("article", "/article/(:alpha)/(:int)/(:slug)"));
        $router->add(RouteFactory::build("product", "/product/(:alpha)/(:int)/(:slug)"));

        $wrongRoute = $router->match("/article/wrong-route/");
        $this->assertFalse($wrongRoute instanceof Melody\Router\Route);
    }

    public function test_get_route() {
        $router = new Router(StandardDefinitionFactory::build());
        $router->add(RouteFactory::build("article", "/article/(:int)/(:slug)"));
        $router->add(RouteFactory::build("product", "/product/(:int)/(:slug)"));

        $articleRoute = $router->get("article");
        $this->assertInstanceof("Melody\Router\Route", $articleRoute);
        $this->assertEquals("article", $articleRoute->getName());

        $productRoute = $router->get("product");
        $this->assertInstanceof("Melody\Router\Route", $productRoute);
        $this->assertEquals("product", $productRoute->getName());

    }

    public function test_get_routes() {
        $router = new Router(StandardDefinitionFactory::build());

        $router->add(RouteFactory::build("article", "/article/(:int)/(:slug)"));
        $router->add(RouteFactory::build("product", "/product/(:int)/(:slug)"));

        $routes = $router->getRoutes();

        $this->assertEquals("article", $routes["article"]->getName());
        $this->assertEquals("product", $routes["product"]->getName());
    }

    public function test_get_not_found_route() {
        $router = new Router(StandardDefinitionFactory::build());

        $this->assertFalse($router->get("not-found-route"));
    }

}

