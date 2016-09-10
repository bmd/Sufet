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

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class ParameterGroup
 *
 * Implements a wrapper over Symfony's ParameterBag object to ensure
 * that header parameters are parsed correctly, and provide a special
 * method for returning the Q-value of a particular header.
 *
 * @package Sufet\Entities
 */
class ParameterGroup extends ParameterBag
{

    /**
     * Parameters constructor.
     *
     * ParameterBag expects an array to fill the $parameters variable, so we
     * override the constructor to implement a custom parsing method.
     *
     * @param  string $paramString
     */
    public function __construct($paramString)
    {
        $this->parameters = $this->parseParameters($paramString);
    }

    /**
     * Decompose a string of header parameters into an array, and assign those
     * into an array to be accessed from the ParameterGroup object.
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
     * Return the value of the quality parameter, or 1.0 if none is present.
     * This helper method is exposed because of the special status that 'q'
     * has among header parameters.
     *
     * @return float
     */
    public function q()
    {
        return floatval($this->get('q', '1.0'));
    }
}