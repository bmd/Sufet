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
    public function __construct($mediaTypeString)
    {
        $this->parseMediaType($mediaTypeString);
    }

    /**
     * @param  string $rawMediaString
     * @return void
     */
    protected function parseMediaType($rawMediaString)
    {
        $split = explode('?', $rawMediaString);
        $rawType = trim($split[0]);
        $this->paramData = (isset($split[1]))
            ? new ParameterGroup($split[1])
            : [];
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