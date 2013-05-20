<?php
namespace Melody\Router\Definitions;

class StandardDefinition implements DefinitionInterface
{
    protected $rules;

    public function addRule($rule, callable $function) {
        $this->rules[$rule] = $function;
    }

    public function getRules() {
        return $this->rules;
    }
}
