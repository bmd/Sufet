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

    /**
     * @group Content
     */
    public function testInstantiatesContentTypeCollections()
    {
        $ct = $this->makeCollection("application/json,*/*;q=0.9");
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentTypeCollection", $ct);
    }

    /**
     * @group Content
     */
    public function testContentTypeCollectionContainsObjectTypes()
    {
        $ct = $this->makeCollection("application/json,*/*;q=0.9");
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentType", $ct->get('application', 'json'));
    }

    /**
     * @group Content
     */
    public function testContentTypeGet()
    {
        $ct = $this->makeCollection("application/json,*/*;q=0.9");

        $this->assertNull($ct->get('text'));
        $this->assertEquals([], $ct->get('text', $first = false));

        $this->assertInstanceOf("\\Sufet\\Entities\\ContentType", $ct->get('application', 'json'));
        $this->assertInternalType('array', $ct->get('application', 'json', $first = false));
    }

}