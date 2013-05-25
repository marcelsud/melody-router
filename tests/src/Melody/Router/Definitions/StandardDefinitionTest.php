<?php

namespace Melody\Router\Definitions;

use Melody\Router\Router;
use Melody\Router\Route;
use Melody\Router\RouteFactory;
use Melody\Router\Definitions\StandardDefinition;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    public function test_standard_definition_factory()
    {
        $definition = StandardDefinition::factory();
        $this->assertInstanceof("Melody\Router\Definitions\StandardDefinition", $definition);
    }

    public function test_matching_alphanumeric_route()
    {
        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("article", "/article/:str/"));

        $route = $router->match("/article/alpha/");
        $this->assertInstanceof("Melody\Router\Route", $route);
    }

    public function test_matching_integer_route()
    {
        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("product", "/product/:int/"));

        $route = $router->match("/product/1234/");
        $this->assertInstanceof("Melody\Router\Route", $route);
    }

    public function test_matching_slug_route()
    {
        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("product", "/product/:slug/"));

        $route = $router->match("/product/test-this-slug/");
        $this->assertInstanceof("Melody\Router\Route", $route);
    }

    public function test_multi_segments_route() {
        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("article", "/article/:str/:int/:slug"));
        $router->add(RouteFactory::build("product", "/product/:str/:int/:slug"));

        $productRoute = $router->match("/product/alpha/1234/test-this-slug/");
        $this->assertInstanceof("Melody\Router\Route", $productRoute);
        $this->assertEquals("product", $productRoute->getName());

        $articleRoute = $router->match("/article/alpha/1234/test-this-slug/");
        $this->assertInstanceof("Melody\Router\Route", $articleRoute);
        $this->assertEquals("article", $articleRoute->getName());
    }

    public function test_route_alnum_rule() {
        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("article", "/article/:alnum/"));

        $articleRoute = $router->match("/article/alphanumeric1234/");
        $this->assertInstanceof("Melody\Router\Route", $articleRoute);
        $this->assertEquals("article", $articleRoute->getName());
    }

    public function test_definition_custom_rule()
    {
        $languages = array("pt", "pt-br", "en");

        $definition = StandardDefinition::factory();
        $definition->addRule(':lang', function($input) use ($languages) {
            return in_array($input, $languages);
        });

        $this->assertTrue($definition->rules[':lang']("pt-br"));
        $this->assertFalse($definition->rules[':lang']("fr"));

        $router = new Router($definition);
        $router->add(RouteFactory::build("article", "/article/:lang/:slug"));

        $route = $router->match("/article/pt-br/this-is-a-slug");
        $this->assertInstanceof("Melody\Router\Route", $route);

        $route = $router->match("/article/en/this-is-another-slug");
        $this->assertInstanceof("Melody\Router\Route", $route);

        $route = $router->match("/article/fr/this-is-another-slug");
        $this->assertFalse($route instanceof Melody\Router\Route);
    }
}

