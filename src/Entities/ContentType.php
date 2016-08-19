<?php
namespace Sufet\Entities;

/**
 * Class ContentType
 * @package Sufet\Entities
 */
class ContentType extends AccessibleEntity
{

    /** @var ParameterGroup */
    protected $parameters;

    /** @var string */
    protected $contentType;

    /**
     * ContentType constructor.
     *
     * @param  string $contentType
     */
    public function __construct($contentType)
    {
        $x = preg_split('/;/', $contentType);
        $this->contentType = trim(array_shift($x));
        $this->parameters = new ParameterGroup($x);

        if (strpos($this->contentType, '/') !== false) {
            $y = preg_split(',/,', $this->contentType);
            $this->baseType = $y[0];
            $this->subType = $y[1];
        } else {
            $this->baseType = $this->contentType;
            $this->subType = null;
        }
    }

    /**
     * Get the parameters.
     *
     * @return \Sufet\Entities\ParameterGroup
     */
    public function params()
    {
        return $this->parameters;
    }

    public function baseType()
    {
        return isset($this->baseType) ? $this->baseType : null;

    }

    public function getSubType()
    {
        return isset($this->subType) ? $this->subType : null;
    }

    public function isWildCardType()
    {
        return isset($this->baseType) && $this->baseType === '*';
    }

    public function isWildCardSubtype()
    {
        return isset($this->subType) && $this->subType === '*';
    }

    public function q()
    {
        print_r($this->parameters);
        return $this->parameters->q();
    }

}