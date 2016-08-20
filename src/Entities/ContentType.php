<?php
/**
 * Sufet is a content-negotiation library and PSR-7 compliant middleware.
 *
 * @category   Sufet
 * @package    Entities
 * @author     Brendan Maione-Downing <b.maionedowning@gmail.com>
 * @copyright  2016
 * @license    MIT
 * @link       https://github.com/bmd/Sufet
 */

namespace Sufet\Entities;

/**
 * Class ContentType
 * @package Sufet\Entities
 */
class ContentType
{
    protected $baseType;

    protected $subType;

    /**
     * The parameter group object attached to any content type
     * object.
     *
     * @var ParameterGroup
     */
    protected $parameters;

    /**
     * The raw content type string, without the query paramters
     * appended to it.
     *
     * @var string
     */
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

        // handle media types that have a subtype parameter or not
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
     * Expose the parameters object to the calling class or method.
     *
     * @return \Sufet\Entities\ParameterGroup
     */
    public function params()
    {
        return $this->parameters;
    }

    /**
     * Get the base content type.
     *
     * For types with subtypes, such as 'application/json', this will
     * return the first segment, 'application'. For content types without
     * subtypes, e.g. charset, this will return the entire type.
     *
     * @param  mixed $default (optional)
     * @return string
     */
    public function getBaseType($default = null)
    {
        return isset($this->baseType) ? $this->baseType : $default;
    }

    /**
     * Get the content subtype, when available, or fall back to
     * a default value.
     *
     * For content types that don't allow a subtype, the value of
     * $default will be returned.
     *
     * @param  mixed $default
     * @return string
     */
    public function getSubType($default = null)
    {
        return isset($this->subType) ? $this->subType : $default;
    }

    /**
     * Return a boolean indicating whether the content type
     * is a wildcard type (i.e. '*' or '*\/*').
     *
     * This method will return false on a wildcard subtype.
     * Use the `isWildCardSubtype()` method instead.
     *
     * @return bool
     */
    public function isWildCardType()
    {
        return isset($this->baseType) && $this->baseType === '*';
    }

    /**
     * Return a boolean indicating whether the content type
     * is a wildcard subtype (e.g. *\/* or text\/*).
     *
     * If the content type does not have a subtype, this method
     * will always return false.
     *
     * @return bool
     */
    public function isWildCardSubtype()
    {
        return isset($this->subType) && $this->subType === '*';
    }

    /**
     * Returns the q-value of the content type as specified by the
     * parameters object. If no qvalue is specified, this method
     * should return '1.0'
     *
     * @return float
     */
    public function q()
    {
        return $this->parameters->q();
    }
}