<?php

namespace Melody\Router;

interface RouteInterface
{
    public function getName();
    public function setName($name);
    public function getPattern();
    public function setPattern($pattern);
    public function getParameters();
    public function setParameters($parameters);
}
