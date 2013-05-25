<?php
namespace Melody\Router;

class Route implements RouteInterface
{
    protected $name;
    protected $pattern;
    protected $parameters;
    protected $inputs = array();

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

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setParameters($parameters)
    {
        if (!isset($parameters['requirements'])) {
            $parameters['requirements']=  array();
        }

        $this->parameters = $parameters;
    }

    public function addInput($key, $value)
    {
        $this->inputs[$key] = $value;
    }

    public function getInputs()
    {
        return $this->inputs;
    }

    public function getInput($key)
    {
        if (isset($this->inputs[$key])) {
            return $this->inputs[$key];
        }

        return false;
    }

}
