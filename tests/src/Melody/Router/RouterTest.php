<?php

namespace Melody\Router;

use Melody\Router\Router;
use Melody\Router\Route;
use Melody\Router\Definitions\StandardDefinition;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    public function test_matching_string_route()
    {
        $parameters['requirements']['name'] = ':str';

        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("hello", "/hello/{name}/", $parameters));

        $route = $router->match("/hello/john/");
        $this->assertEquals("john", $route->getInput("name"));
    }

    public function test_get_route_pattern()
    {
        $pattern = "/posts/a-successful-git-branching-model/";

        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("posts", $pattern));

        $route = $router->match($pattern);
        $this->assertEquals($pattern, $route->getPattern());
    }

    public function test_get_route_inputs()
    {
        $parameters['requirements']['slug'] = ':slug';
        $parameters['requirements']['id'] = ':int';

        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("hello", "/product/{slug}/{id}", $parameters));

        $route = $router->match("/product/note-book-dell/1234");
        $inputs = $route->getInputs();

        $this->assertEquals("note-book-dell", $inputs["slug"]);
        $this->assertEquals(1234, $inputs["id"]);
        $this->assertFalse($route->getInput("name"));
    }

    public function test_no_segments_route() {
        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("home", "/"));

        $homeRoute = $router->match("/");
        $this->assertEquals("home", $homeRoute->getName());
    }

    public function test_not_matching_route()
    {
        $parameters['requirements']['article_name'] = ':alpha';

        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("article", "/article/{article_name}/", $parameters));

        $wrongRoute = $router->match("/article/not-a-alpha-string/");
        $this->assertFalse($wrongRoute instanceof Melody\Router\Route);
    }

    public function test_get_route() {
        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("article", "/article/{id}/{article_slug}"));
        $router->add(RouteFactory::build("product", "/product/{id}/{product_slug}"));

        $articleRoute = $router->get("article");
        $this->assertInstanceof("Melody\Router\Route", $articleRoute);
        $this->assertEquals("article", $articleRoute->getName());

        $productRoute = $router->get("product");
        $this->assertInstanceof("Melody\Router\Route", $productRoute);
        $this->assertEquals("product", $productRoute->getName());

    }

    public function test_get_routes() {
        $router = new Router(StandardDefinition::factory());

        $router->add(RouteFactory::build("article", "/article/{id}/{article_slug}"));
        $router->add(RouteFactory::build("product", "/product/{id}/{product_slug}"));

        $routes = $router->getRoutes();

        $this->assertEquals("article", $routes["article"]->getName());
        $this->assertEquals("product", $routes["product"]->getName());
    }

    public function test_get_not_found_route() {
        $router = new Router(StandardDefinition::factory());

        $this->assertFalse($router->get("/not-found-page/"));
    }

    public function test_match_not_found_route() {
        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("product_list", "/admin/product/list/"));

        $route = $router->match("/product/list/");
        $this->assertFalse($route instanceof Melody\Router\Route);
    }

}
