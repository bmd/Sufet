<?php
namespace Sufet\Negotiators;
use Sufet\Entities\ContentType;
use Sufet\Entities\ContentTypeCollection;

/**
 * Class AcceptCharsetNegotiator
 * @package Sufet\Negotiators
 */
class AcceptCharsetNegotiator extends AbstractNegotiator
{
    /**
     * AcceptCharsetNegotiator constructor.
     *
     * @param string $rawHeader
     */
    public function __construct($rawHeader)
    {
        $this->contentTypes = new ContentTypeCollection($rawHeader);
    }

    /**
     * @inheritdoc
     */
    public function wants($type)
    {
        foreach ($this->contentTypes->getBestType() as $candidate) {
            if ($candidate->baseName === $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  string $type
     * @param  string $to
     * @return bool
     */
    public function prefers($type, $to)
    {
        $c = new ContentType($type);
        $t = new ContentType($to);
        if (!isset($this->contentTypes[$type]) && !isset($this->contentTypes[$to])) {
            return false;
        }
        return $this->contentTypes[$type]->q() >= $this->contentTypes[$type]->q();
    }

    public function willAccept($type)
    {
        $c = new ContentType($type);
    }

    public function best()
    {
        // TODO: Implement best() method.
    }

    protected function parseHeader($headerContent)
    {
        // TODO: Implement parseHeader() method.
    }


}