<?php

namespace Melody\Router;

use Melody\Router\Definitions\DefinitionInterface;

interface RouterInterface
{
    public function __construct(DefinitionInterface $definition);
    public function add(RouteInterface $route);
    public function match($url);
}
