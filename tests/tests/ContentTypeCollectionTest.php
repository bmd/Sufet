<?php
/**
 * Sufet is a content-negotiation library and PSR-7 compliant middleware.
 *
 * @category   Sufet
 * @package    Tests
 * @author     Brendan Maione-Downing <b.maionedowning@gmail.com>
 * @copyright  2016
 * @license    MIT
 * @link       https://github.com/bmd/Sufet
 */

use Sufet\Entities\ContentTypeCollection;

/**
 * Class ContentTypeCollectionTest
 */
class ContentTypeCollectionTest extends PHPUnit_Framework_TestCase
{

    protected function makeCollection($raw)
    {
        return new ContentTypeCollection($raw);
    }

    public function testInstantiatesContentTypeCollections()
    {
        $ct = $this->makeCollection("application/json,*/*;q=0.9");
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentTypeCollection", $ct);
    }

    public function testContentTypeCollectionContainsObjectTypes()
    {
        $ct = $this->makeCollection("application/json,*/*;q=0.9");
    }
}