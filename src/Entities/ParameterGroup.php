<?php
namespace Sufet\Entities;

/**
 * Class ParameterGroup
 * @package Sufet\Entities
 */
class ParameterGroup extends AccessibleEntity
{

    /**
     * Parameters constructor.
     *
     * @param $paramString
     */
    public function __construct($paramString)
    {
        $this->data = $this->parseParameters($paramString);
    }

    /**
     * @param $params
     */
    protected function parseParameters($params)
    {

    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

}