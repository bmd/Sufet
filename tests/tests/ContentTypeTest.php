<?php

use Sufet\Entities\ContentType;

/**
 * Class ContentTypeTest
 */
class ContentTypeTest extends PHPUnit_Framework_TestCase
{

    public function testInstantiatesContentGroupFromStrings()
    {
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentType", new ContentType('UTF-8;q=0.7'));
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentType", new ContentType('*/*;q=0.1'));
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentType", new ContentType('text/html;q=1.0;foo=bar'));
    }

    public function testNonSubtypeContentType()
    {
        $content = new ContentType('UTF-8;q=0.7;foo=bar');
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentType", $content);
        $this->assertEquals('0.7', $content->q());
        $this->assertEquals('bar', $content->params()->foo);
        $this->assertNull($content->getSubType());
        $this->assertFalse($content->isWildCardSubtype());
    }

    public function testSubtypeContentType()
    {

    }


}