<?php
namespace Sufet\Entities;

/**
 * Class ContentType
 * @package Sufet\Entities
 */
class ContentType extends AbstractNegotiable
{
    /**
     * @param string $header
     */
    protected function parseType(string $header): void
    {
        $this->raw = $header;

        // normalize to lowercase
        $header = strtolower($header);
        // split the type from the parameters
        [$type, $params] = (strpos($header, ';') !== false)
            ? explode(';', $header, $limit = 2)
            : [$header, ''];

        $this->type = $type;
        $this->parameters = new Parameters($params);

        // set the type and subtype as necessary;
        [$baseType, $subType] = (strpos($this->type, '/') !== false)
            ? explode('/', $this->type, $limit = 2)
            : [$this->type, null];

        $this->baseType = $baseType;
        $this->subType = $subType;
    }
}