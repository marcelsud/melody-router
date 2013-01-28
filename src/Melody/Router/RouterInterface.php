<?php

namespace Melody\Router;

interface RouterInterface
{
    public function __construct(DefinitionFactoryInterface $definitionFactory);
    public function add(RouteInterface $route);
    public function match($url);
}
