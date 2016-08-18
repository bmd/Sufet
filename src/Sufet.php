<?php
namespace Sufet;

/**
 * Class Sufet
 * @package Sufet
 */
class Sufet
{

    /**
     * Use the name of the header being negotiated to instantiate a negotiator
     * object. Sufet uses a name-mapping convention to map the header's name to
     * a class instance.
     *
     * For example "accept-encoding" will search for a class called
     * \Sufet\Negotiators\AcceptEncodingNegotiator, and raise an error if the
     * class doesn't exist under that namespace. While Sufet provides handling
     * for the 'accept', 'accept-charset', 'accept-encoding' and
     * 'accept-language' headers out of the box, you can always extend it to
     * handle more headers by using class_alias() to declare your own class
     * that implements \Sufet\Negotiators\AbstractNegotiatior within the
     * \Sufet\Negotiators namespace. This means that you can easily plug
     * your own classes into Sufet's middleware handler to negotiate based on
     * the contents of an arbitrary 'accept-*' header.
     *
     * @param  string $headerName
     * @param  string $headerContent
     * @return \Sufet\Negotiators\AbstractNegotiator
     * @throws \DomainException
     */
    public static function makeNegotiator($headerName, $headerContent)
    {
        $kls = "\\Sufet\\Negotiators\\" . str_replace('-', '', ucwords(strtolower($headerName), '-')) . "Negotiator";

        if (!class_exists($kls)) {
            throw new \DomainException("Can't negotiate based on header '$headerName'");
        }

        return new $kls($headerContent);
    }
}