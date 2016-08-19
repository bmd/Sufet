<?php
/**
 * Sufet is a content-negotiation library and PSR-7 compliant middleware.
 *
 * @category   Sufet
 * @package    Negotiators
 * @author     Brendan Maione-Downing <author@example.com>
 * @copyright  2016
 * @license    MIT
 * @link       https://github.com/bmd/Sufet
 */

namespace Sufet\Negotiators;
use Sufet\Entities\ContentType;

/**
 * Class AcceptLanguageNegotiator
 * @package Sufet\Negotiators
 */
class AcceptLanguageNegotiator extends AbstractNegotiator
{
    /**
     * AcceptLanguageNegotiator constructor.
     */
    public function __construct()
    {
    }

    protected function parseHeader($headerContent)
    {
        // TODO: Implement parseHeader() method.
    }


    public function wants($type)
    {
        // TODO: Implement wants() method.
    }

    public function prefers($type, $to)
    {
        // TODO: Implement prefers() method.
    }

    public function willAccept($type)
    {
        // TODO: Implement willAccept() method.
    }

    public function best()
    {
        // TODO: Implement best() method.
    }

    protected function sortTypes(ContentType $a, ContentType $b)
    {
        // TODO: Implement sortTypes() method.
    }


}