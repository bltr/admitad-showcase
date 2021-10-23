<?php

namespace App\Services\Feed;

use ErrorException;
use Generator;
use Illuminate\Support\Str;
use SimpleXMLElement;
use XMLReader;

class XMLFileReader
{
    private XMLReader $reader;

    public function __construct(XMLReader $reader)
    {
        $this->reader = $reader;
    }

    public function open(string $fileName)
    {
        $this->reader->open($fileName);
    }

    /**
     * @param string $tagName
     * @return Generator|array
     * @throws ErrorException
     */
    public function getIterator(string $tagName): Generator
    {
        $pluralTagName = Str::plural($tagName);

        while (($isSuccess = $this->reader->read()) && !$this->isTagStarted($pluralTagName)) continue;

        if (!$isSuccess) {
            throw new ErrorException('XMLReader::read(): incorrect feed format');
        }

        while (($isSuccess = $this->reader->read()) && !$this->isTagEnded($pluralTagName)) {
            if ($this->isTagStarted($tagName)) {
                yield $this->xml2array(simplexml_load_string($this->reader->readOuterXml()));
            }
        }

        if (!$isSuccess) {
            throw new ErrorException('XMLReader::read(): incorrect feed format');
        }
    }

    private function isTagStarted(string $tagName): bool
    {
        return $this->reader->nodeType === XMLReader::ELEMENT && $this->reader->name === $tagName;
    }

    private function isTagEnded(string $tagName): bool
    {
        return $this->reader->nodeType === XMLReader::END_ELEMENT && $this->reader->name === $tagName;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return array|string
     */
    private function xml2array(SimpleXMLElement $xml)
    {
        $result = [];

        foreach($xml->attributes() as $name=>$value) {
            $result[$name] = (string) $value;
        }

        if ($xml->count() > 0) {
            foreach ($xml->children() as $child) {
                if ($xml->{$child->getName()}->count() > 1) {
                    $result[$child->getName()][] = $this->xml2array($child);
                } else {
                    $result[$child->getName()] = $this->xml2array($child);
                }
            }
        } elseif (!empty($result)) {
            $result['value'] = (string) $xml;
        } else {
            $result = (string) $xml;
        }

        return $result;
    }
}
