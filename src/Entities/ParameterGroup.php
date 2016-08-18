<?php
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
     * @param  string $params
     * @return array
     */
    protected function parseParameters($params)
    {
        if (!$params) {
            return [];
        }

        $holder = [];
        foreach (explode(';', $params) as $param) {
            $components = explode('=', $param);
            $holder[trim($components[0])] = trim($components[1]);
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
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        return $default;
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