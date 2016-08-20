<?php

use Sufet\Entities\ContentType;

/**
 * Class ContentTypeTest
 */
class ContentTypeTest extends PHPUnit_Framework_TestCase
{

    protected function getContentType($content)
    {
        return new ContentType($content);
    }

    public function testInstantiatesContentGroupFromStrings()
    {
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentType", $this->getContentType('UTF-8;q=0.7'));
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentType", $this->getContentType('*/*;q=0.1'));
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentType", $this->getContentType('text/html;q=1.0;foo=bar'));
    }

    public function testContentTypeWithoutParameters()
    {
        $content = $this->getContentType('application/json');
        $this->assertFalse($content->isWildCardType());
        $this->assertEquals('application', $content->getBaseType());
        $this->assertEquals('json', $content->getSubType());
    }

    public function testNonSubtypeContentType()
    {
        $content = $this->getContentType('UTF-8;q=0.7;foo=bar');
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentType", $content);
        $this->assertEquals('0.7', $content->q());
        $this->assertEquals('bar', $content->params()->foo);
        $this->assertNull($content->getSubType());
        $this->assertFalse($content->isWildCardSubtype());
    }

    public function testSubtypeContentType()
    {
        $content = $this->getContentType('application/json;q=0.7;foo=bar');
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentType", $content);
        $this->assertEquals('0.7', $content->q());
        $this->assertEquals('bar', $content->params()->foo);
        $this->assertEquals('json', $content->getSubType());
        $this->assertEquals('application', $content->getBaseType());
        $this->assertFalse($content->isWildCardSubtype());
    }

    public function testWildCardType()
    {
        $content = $this->getContentType('*/*;foo=bar');
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentType", $content);
        $this->assertEquals('1.0', $content->q());
        $this->assertEquals('bar', $content->params()->foo);
        $this->assertEquals('*', $content->getSubType());
        $this->assertEquals('*', $content->getBaseType());
        $this->assertTrue($content->isWildCardType());
    }

    public function testWildCardSubType()
    {
        $content = $this->getContentType('text/*;FOO=bar');
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentType", $content);
        $this->assertEquals('1.0', $content->q());
        $this->assertEquals('bar', $content->params()->foo);
        $this->assertEquals('*', $content->getSubType());
        $this->assertEquals('text', $content->getBaseType());
        $this->assertFalse($content->isWildCardType());
        $this->assertTrue($content->isWildCardSubtype());
    }
}