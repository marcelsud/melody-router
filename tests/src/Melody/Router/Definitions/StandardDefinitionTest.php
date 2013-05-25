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
        $parameters['requirements']['article_name'] = ':str';

        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("article", "/article/{article_name}/", $parameters));

        $route = $router->match("/article/alpha/");
        $this->assertInstanceof("Melody\Router\Route", $route);
    }

    public function test_matching_integer_route()
    {
        $parameters['requirements']['id'] = ':int';

        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("product", "/product/{id}/", $parameters));

        $route = $router->match("/product/1234/");
        $this->assertInstanceof("Melody\Router\Route", $route);
    }

    public function test_matching_slug_route()
    {
        $parameters['requirements']['product_name'] = ':slug';

        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("product", "/product/{product_name}/", $parameters));

        $route = $router->match("/product/test-this-the-slug/");
        $this->assertInstanceof("Melody\Router\Route", $route);
    }

    public function test_multi_segments_route() {
        $parameters['requirements']['product_id'] = ':int';
        $parameters['requirements']['product_name'] = ':str';
        $parameters['requirements']['product_slug'] = ':slug';

        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("product", "/product/{product_name}/{product_slug}/{product_id}", $parameters));

        $productRoute = $router->match("/product/alpha/test-this-slug/1234/");
        $this->assertInstanceof("Melody\Router\Route", $productRoute);
        $this->assertEquals("product", $productRoute->getName());
    }

    public function test_route_alnum_rule() {
        $parameters['requirements']['article_name'] = ':alnum';

        $router = new Router(StandardDefinition::factory());
        $router->add(RouteFactory::build("article", "/article/{article_name}/", $parameters));

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

        $parameters['requirements']['language'] = ':lang';
        $parameters['requirements']['article_name'] = ':slug';

        $router = new Router($definition);
        $router->add(RouteFactory::build("article", "/article/{language}/{article_name}", $parameters));

        $route = $router->match("/article/pt-br/this-is-a-slug");
        $this->assertInstanceof("Melody\Router\Route", $route);

        $route = $router->match("/article/en/this-is-another-slug");
        $this->assertInstanceof("Melody\Router\Route", $route);

        $route = $router->match("/article/fr/this-is-another-slug");
        $this->assertFalse($route instanceof Melody\Router\Route);
    }
}

