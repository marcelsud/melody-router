<?php
namespace Melody\Router\Definitions;

interface DefinitionInterface
{
    public function addRule($rule, callable $function);
    public function getRules();
}
