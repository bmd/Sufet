<?php
namespace Sufet\Entities;

/**
 * Class MediaType
 * @package Sufet\Entities
 */
class MediaType extends AccessibleEntity
{

    protected $paramData;

    /**
     * MediaType constructor.
     */
    public function __construct()
    {
    }

    public function q()
    {
        return $this->paramData['q'] ?: 1.0;
    }

    /**
     * @param  string|null $name
     * @return string|\Sufet\Entities\ParameterGroup
     */
    public function param($name = null)
    {
        if (!$name) {
            return $this->paramData;
        }

        return $this->paramData[$name];
    }
}