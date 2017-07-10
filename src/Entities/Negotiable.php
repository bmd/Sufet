<?php
namespace Sufet\Entities;

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class Negotiable
 * @package Sufet\Entities
 */
interface Negotiable
{
    /**
     * Return the value of the quality parameter, or 1.0 if none is present.
     * This helper method is exposed because of the special status that 'q'
     * has among header parameters.
     *
     * @see https://tools.ietf.org/html/rfc7231#section-5.3.1
     *
     * @return float
     */
    public function q(): float;

    /**
     * Return the normalized type value, not including the query string.
     *
     * @param  mixed $default
     * @return null|string
     */
    public function getType($default = null): ?string;

    /**
     * Get the raw header value that was used to construct this negotiable
     * entity. This will include the query string, and is not normalized.
     *
     * @param  mixed $default
     * @return null|string
     */
    public function getRawType($default = null): string;

    /**
     * Get the base content type.
     *
     * For types with subtypes, such as 'application/json', this will return
     * the first segment, 'application'. For content types without subtypes,
     * e.g. charset, this will return the entire type.
     *
     * @param  mixed $default
     * @return null|string
     */
    public function getBaseType($default = null): ?string;

    /**
     * Get the content subtype, when available, or fall back to a default
     * value.
     *
     * For content types that don't allow a subtype, the value of $default
     * will be returned.
     *
     * @param  mixed $default
     * @return string
     */
    public function getSubType($default = null): ?string;

    /**
     * @param string $name
     * @param null $default
     * @return null|string
     */
    public function param(string $name, $default = null): ?string;

    /**
     * @return ParameterBag
     */
    public function params(): ParameterBag;
}