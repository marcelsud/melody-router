<?php
namespace Melody\Router\Definitions;

use Closure;

class StandardDefinition implements DefinitionInterface
{
    protected $rules;

    public function addRule($rule, Closure $function) {
        $this->rules[$rule] = $function;
    }

    public function getRules() {
        return $this->rules;
    }
}
