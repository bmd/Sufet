<?php

use Sufet\Negotiators\AcceptLanguageNegotiator;

class AcceptLanguageNegotiatorTest extends PHPUnit_Framework_TestCase
{

    protected function getNegotiator($language)
    {
        return new AcceptLanguageNegotiator($language);
    }

    public function testInstantiatesNegotiator()
    {
        $this->assertTrue(true);
    }

}
