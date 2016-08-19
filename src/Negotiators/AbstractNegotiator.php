<?php
namespace Sufet\Negotiators;
use Sufet\Entities\ContentType;

/**
 * Class AbstractNegotiator
 * @package Sufet\Negotiators
 */
abstract class AbstractNegotiator
{
    /** @var string */
    protected $contentTypes;

    /** @var string */
    protected $headerName;

    /**
     * AbstractNegotiator constructor.
     * @param $headerContent
     */
    public function __construct($headerContent)
    {
        $this->parseHeader($headerContent);
    }

    abstract protected function parseHeader($headerContent);

    abstract protected function sortTypes(ContentType $a, ContentType $b);

    /**
     * Return a boolean value indicating if the content type specified
     * in $type is the MOST preferred content type based on the header.
     *
     * If two options are equally preferred (i.e. both have q=1.0) and
     * equally specific (i.e. both are or are not wildcard types and
     * subtypes).
     *
     * @param  string $type
     * @return bool
     */
    abstract public function wants($type);

    abstract public function prefers($type, $to);

    abstract public function willAccept($type);

    /**
     * Return the most suitable content type based on the request
     * headers.
     *
     * @return \Sufet\Entities\ContentType;
     */
    public function best()
    {
        return usort($this->contentTypes->all(), [self::class, 'sortTypes']);
    }
}