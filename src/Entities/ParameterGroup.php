<?php
/**
 * Sufet is a content-negotiation library and PSR-7 compliant middleware.
 *
 * @category   Sufet
 * @package    Middleware
 * @author     Brendan Maione-Downing <b.maionedowning@gmail.com>
 * @copyright  2016
 * @license    MIT
 * @link       https://github.com/bmd/Sufet
 */

namespace Sufet\Entities;

/**
 * Class ParameterGroup
 * @package Sufet\Entities
 */
class ParameterGroup extends AccessibleEntity
{

    /**
     * Parameters constructor.
     *
     * @param  string $paramString
     */
    public function __construct($paramString)
    {
        $this->data = $this->parseParameters($paramString);
    }

    /**
     * Decompose a string of header parameters into an array, and
     * assign those into an array to be accessed from the
     * ParameterGroup object.
     *
     * @param  array $params
     * @return array
     */
    protected function parseParameters(array $params)
    {
        $holder = [];
        foreach ($params as $param) {
            $components = preg_split('/=/', $param);
            $holder[strtolower(trim($components[0]))] = strtolower(trim($components[1]));
        }

        return $holder;
    }

    /**
     * Return a single parameter value without committing to the
     * existance of that particular key.
     *
     * Unlike the direct access methods (array or object), a $default
     * value can be specified as a fallback if the value is not
     * set in the data bag.
     *
     * @param  string $key
     * @param  mixed  $default (optional)
     * @return mixed
     */
    public function param($key, $default = null)
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : $default;
    }

    /**
     * Return the value of the quality parameter, or 1.0 if none
     * is present. This helper method is exposed because of the
     * special status that 'q' has among header parameters.
     *
     * @return  float
     */
    public function q()
    {
        return array_key_exists('q', $this->data) ? floatval($this->data['q']) : 1.0;
    }

    /**
     * Return the complete array of parsed parameters to the
     * calling object to be consumed without requiring a separate
     * call to retrieve each parameter, or to know the available
     * parameters ahead of time.
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }
}