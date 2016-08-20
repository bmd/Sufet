<?php
/**
 * Sufet is a content-negotiation library and PSR-7 compliant middleware.
 *
 * @category   Sufet
 * @package    Negotiators
 * @author     Brendan Maione-Downing <b.maionedowning@gmail.com>
 * @copyright  2016
 * @license    MIT
 * @link       https://github.com/bmd/Sufet
 */

namespace Sufet\Negotiators;

use Sufet\Entities\ContentType;
use Sufet\Entities\ContentTypeCollection;

/**
 * Class AbstractNegotiator
 * @package Sufet\Negotiators
 */
abstract class AbstractNegotiator implements \ArrayAccess
{
    /**
     * The collection of content types included in the header.
     * The ContentTypeCollection object contains object
     * representations of each type included in the header.
     *
     * @var ContentTypeCollection
     */
    protected $contentTypes;

    /**
     * The name of the original HTTP header that this class
     * will negotiate on.
     *
     * @var string
     */
    protected $headerName;

    /**
     * AbstractNegotiator constructor.
     *
     * @param  string $headerContent
     */
    public function __construct($headerContent)
    {
        $this->contentTypes = $this->parseHeader($headerContent);
    }

    /**
     * Parse the raw HTTP header string into a set of negotiable
     * PHP objects.
     *
     * This function should usually be called from within the
     * negotiator's `__construct()` method to avoid a situation
     * where a content object is requested from the response
     * object but hasn't yet been created.
     *
     * @param  string $headerContent
     * @return ContentTypeCollection
     */
    abstract protected function parseHeader($headerContent);

    /**
     * Sort the objects within a ContentTypeCollection based on
     * a custom algorithm.
     *
     * For headers with a specification within an accepted HTTP
     * RFC, this will implement the logic specified in that RFC.
     * For a custom negotiator type, this logic should be defined
     * within the class that extends `AbstractNegotiator`.
     *
     * @param  \Sufet\Entities\ContentType $a
     * @param  \Sufet\Entities\ContentType $b
     * @return mixed
     */
    abstract protected function sortTypes(ContentType $a, ContentType $b);

    /**
     * Return a boolean value indicating if the content type specified
     * in `$type` is the MOST preferred content type based on the
     * header.
     *
     * If two options are equally preferred (i.e. both have q=1.0) and
     * equally specific (i.e. both are or are not wildcard types and
     * subtypes).
     *
     * @param  string $type
     * @return bool
     */
    abstract public function wants($type);

    /**
     * Return a boolean value indicating if the content type specified
     * in `$type` is AT LEAST as satisfactory to the client as the
     * type specified by `$to`.
     *
     * If two types are equally preferred (i.e. have the same level of
     * specificity and the same q-value), then the return value will
     * be true.
     *
     * @param  string $type
     * @param  string $to
     * @return mixed
     */
    abstract public function prefers($type, $to);

    /**
     * Return a boolean value indicating whether the specified content
     * type is acceptable AT ALL to the client.
     *
     * Unless the wildcard types - * and *\/* - are explicitly refused
     * with q=0.0, they will always be considered acceptable.
     *
     * @param  string $type
     * @return mixed
     */
    abstract public function willAccept($type);

    /**
     * Return the most suitable content type based on the request
     * headers.
     *
     * By default, `best()` will use the header-specific `sortTypes()`
     * specified in the instantiated negotiator class to select a
     * header, but can be overridden within the negotiator to use
     * any set of criteria for selecting a "best" type.
     *
     * @return \Sufet\Entities\ContentType;
     */
    public function best()
    {
        $sortArray = $this->contentTypes->all();
        usort($sortArray, [self::class, 'sortTypes']);
        return $sortArray[0];
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->contentTypes);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        return $this->contentTypes[$offset];
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        throw new \LogicException("Setting Content Types via array access syntax is not supported");
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        throw new \LogicException("Unsetting Content Types via array access syntax is not supported");
    }

}