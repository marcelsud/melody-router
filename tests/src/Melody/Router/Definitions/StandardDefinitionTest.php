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

    public function test_defiition_custom_rule()
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

