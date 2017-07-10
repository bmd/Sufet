<?php
namespace Sufet\Entities;

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class Parameters
 *
 * Implements a wrapper over Symfony's ParameterBag object to ensure
 * that header parameters are parsed correctly, and provide a special
 * method for returning the Q-value of a particular header.
 *
 * @package Sufet\Entities
 */
class Parameters extends ParameterBag
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
        parent::__construct($this->parseParameters($this->normalize($paramString)));
    }

    protected function normalize($paramString)
    {
        return strtolower($paramString);
    }

    /**
     * Decompose a string of header parameters into an array, and assign those
     * into an array to be accessed from the ParameterGroup object.
     *
     * @param  string $params
     * @return array
     */
    protected function parseParameters(string $params): array
    {
        $holder = [];

        // handle the case where the query string is empty, or malformed
        if (!$params) {
            return $holder;
        }

        foreach (explode(';', $params) as $param) {
            // make sure each parameter appears well-formed
            if (strpos($param, '=') !== false) {
                [$name, $value] = explode('=', $param, $limit = 2);
                $holder[$name] = $value;
            }
        }

        return $holder;
    }

    /**
     * @inheritdoc
     */
    public function q()
    {
        return floatval($this->get('q', '1.0'));
    }
}