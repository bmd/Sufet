<?php
namespace Sufet;

/**
 * Class Sufet
 * @package Sufet
 */
class Sufet
{
    /** @var array */
    public static $negotiatorRegistry = [
        'accept' => 'Media',
        'accept-charset' => 'Charset',
        'accept-encoding' => 'Encoding',
        'accept-language' => 'Language',
    ];

    /**
     * @param  string $headerName
     * @param  string $headerContent
     * @return \Sufet\Negotiators\AbstractNegotiator;
     */
    public static function makeNegotiator($headerName, $headerContent)
    {
        $normalizedHeaderName = strtolower($headerName);

        if (!array_key_exists($normalizedHeaderName, self::$negotiatorRegistry)) {
            throw new \DomainException("Can't negotiate based on header '$headerName'");
        }

        $className = "\\Sufet\\Negotiators\\" . self::$negotiatorRegistry[$normalizedHeaderName];
        return new $className($headerContent);
    }
}