<?php
namespace Melody\Router\Definitions;

class StandardDefinitionFactory implements DefinitionFactoryInterface
{
    public static function build()
    {
        $definition = new StandardDefinition();
        $definition->addRule('(:int)', function ($input) {
            return is_numeric($input) && (int) $input == $input;
        });

        $definition->addRule('(:str)', function ($input) {
            return preg_match('/^[a-zA-Z]+$/', $input);
        });

        $definition->addRule('(:alnum)', function ($input) {
            return preg_match('/^[a-zA-Z0-9]+$/', $input);
        });

        $definition->addRule('(:slug)', function ($input) {
            return preg_match('/^[a-z][-a-z0-9]*$/', $input);
        });

        $definition->addRule('(:alpha)', function ($input) {
            return ctype_alpha($input);
        });


        return $definition;
    }
}
