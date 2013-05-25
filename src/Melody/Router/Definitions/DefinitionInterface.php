<?php
namespace Melody\Router\Definitions;

use Closure;

interface DefinitionInterface
{
    public function addRule($rule, Closure $callback);
    public function exists($rule);
    public static function factory();
}
