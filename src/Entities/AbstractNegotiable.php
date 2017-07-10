<?php
namespace Sufet\Entities;

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class AbstractNegotiable
 * @package Sufet\Entities
 */
abstract class AbstractNegotiable implements Negotiable
{
    /**
     * The base type of the content type entity. If the content type does not
     * have a subtype, then this will contain the complete type and the
     * subtype will be null.
     *
     * @var string
     */
    protected $baseType;

    /**
     * The content subtype, if available. If there is no subtype specification,
     * e.g. for the 'accept-encoding' header, then the subtype will be null.
     *
     * @var string|null
     */
    protected $subType;

    /**
     * The base type string, without the query paramters appended to it. E.g.,
     * if I had a type "text/html;q=0.8,version=3", the $type property would
     * contain "text/html"
     *
     * @var string
     */
    protected $type;

    /**
     * The full raw negotiable header value
     *
     * @var string
     */
    protected $raw;

    /** @var Parameters */
    protected $parameters;

    /**
     * AbstractNegotiable constructor.
     * @param string $header
     */
    public function __construct(string $header)
    {
        $this->parseType($header);
    }

    /**
     * @param string $header
     * @return void
     */
    abstract protected function parseType(string $header): void;

    /**
     * @inheritdoc
     */
    public function q(): float
    {
        return $this->parameters->q();
    }

    /**
     * @inheritdoc
     */
    public function getRawType($default = null): string
    {
        return empty($this->raw) ? $default : $this->raw;
    }

    /**
     * @inheritdoc
     */
    public function getType($default = null): ?string
    {
        $base = $this->getBaseType();
        $sub = $this->getSubType();

        if ($base && $sub) {
            return "{$base}/{$sub}";
        }

        if ($base) {
            return $base;
        }

        if ($default) {
            return $default;
        }

        return "*/*";
    }

    /**
     * @inheritdoc
     */
    public function getBaseType($default = null): ?string
    {
        return empty($this->baseType) ? $default : $this->baseType;
    }

    /**
     * @inheritdoc
     */
    public function getSubType($default = null): ?string
    {
        return empty($this->subType) ? $default : $this->subType;
    }

    /**
     * Return a boolean indicating whether the content type is a wildcard type
     * (i.e. '*' or '*\/*').
     *
     * This method will return false on a wildcard subtype. Use the
     * `isWildCardSubtype()` method instead.
     *
     * @return bool
     */
    public function isWildCardType(): bool
    {
        return isset($this->baseType) && $this->baseType === '*';
    }

    /**
     * Return a boolean indicating whether the content type is a wildcard
     * subtype (e.g. *\/* or text\/*).
     *
     * If the content type does not have a subtype, this method will always
     * return false.
     *
     * @return bool
     */
    public function isWildCardSubtype(): bool
    {
        return isset($this->subType) && $this->subType === '*';
    }

    /**
     * @inheritdoc
     */
    public function params(): ParameterBag
    {
        return $this->parameters;
    }

    /**
     * @inheritdoc
     */
    public function param(string $name, $default = null): ?string
    {
        return $this->parameters->get($name, $default);
    }
}