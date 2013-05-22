<?php
namespace Melody\Router\Definitions;

use Closure;

interface DefinitionInterface
{
    public function addRule($rule, Closure $function);
    public function getRules();
}
