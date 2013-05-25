<?php
namespace Melody\Router\Definitions;

use Closure;

class StandardDefinition implements DefinitionInterface
{
    public $rules = array();

    public static function factory()
    {
        $definition = new self();

        $definition->rules[':int'] = function ($input) {
            return is_numeric($input) && (int) $input == $input;
        };

        $definition->rules[':str'] = function ($input) {
            return ctype_alpha($input);
        };

        $definition->rules[':alnum'] = function ($input) {
            return preg_match('/^[a-zA-Z0-9]+$/', $input);
        };

        $definition->rules[':slug'] = function ($input) {
            return preg_match('/^[a-z][-a-z0-9]*$/', $input);
        };

        return $definition;
    }

    public function addRule($rule, Closure $callback)
    {
        $this->rules[strtolower($rule)] = $callback;
    }

    public function exists($rule)
    {
        return isset($this->rules[$rule]);
    }

}
