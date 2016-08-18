<?php
namespace Sufet\Parsers;

use Sufet\Entities\AccessibleEntity;

/**
 * Class MediaTypeParser
 * @package Sufet\Entities
 */
class AcceptParser extends AccessibleEntity implements ParserInterface
{
    /** @var  */
    protected $paramData;

    public function parseHeader($header)
    {
        // TODO: Implement parseHeader() method.
    }


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