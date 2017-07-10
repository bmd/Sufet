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

use Sufet\Entities\ContentType;
use Sufet\Entities\NegotiableCollection;

/**
 * Class ContentTypeCollectionTest
 */
class ContentTypeCollectionTest extends PHPUnit_Framework_TestCase
{
    public function validHeaderProvider()
    {
        return [
            ['text/html,text/*;q=0.9'],
            ['application/json;version=1;q=0.75, application/json;version=2'],
            ['text'],
        ];
    }

    /**
     * @test
     * @dataProvider validHeaderProvider
     * @param string $h
     */
    public function it_should_create_collection_object_from_valid_headers(string $h)
    {
        $collection = new NegotiableCollection($h);

        $this->assertInstanceOf(NegotiableCollection::class, $collection);
    }

    /**
     * @test
     * @dataProvider validHeaderProvider
     * @param string $h
     */
    public function it_should_contain_content_type_objects($h)
    {
        $collection = new NegotiableCollection($h);

        $this->assertNotEmpty($collection->all());
        $this->assertContainsOnlyInstancesOf(ContentType::class, $collection->all());
    }

    /**
     * @test
     */
    public function it_should_search_for_content_types_by_name()
    {
        $collection = new NegotiableCollection("application/json,*/*;q=0.9");

        $this->assertNull($collection->find('text'));
        $this->assertEquals([], $collection->find('text', null, [], false));

        $this->assertInstanceOf(ContentType::class, $collection->find('application', 'json'));
        $this->assertNull($collection->find('text', 'html'));
        $this->assertInternalType('array', $collection->find('application', 'json', [], $first = false));
    }
}