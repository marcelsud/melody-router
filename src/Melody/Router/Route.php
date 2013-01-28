<?php
namespace Melody\Router;

class Route implements RouteInterface
{
    protected $name;
    protected $pattern;
    protected $compiledPattern;
    protected $parameters = array();

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }

    public function getCompiledPattern()
    {
        return $this->compiledPattern;
    }

    public function setCompiledPattern($compiledPattern)
    {
        $this->compiledPattern = $compiledPattern;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function match($request)
    {
        return (bool) preg_match('#^' . $this->getCompiledPattern() . '$#', $request);
    }
}
