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
    private FileNameHelper $fileName;

    public function __construct(XMLReader $reader, FileNameHelper $fileName)
    {
        $this->reader = $reader;
        $this->fileName = $fileName;
    }

    public function init(int $shop_id)
    {
        $this->reader->open(($this->fileName)($shop_id));
    }

    /**
     * @param string $tag_name
     * @return Generator|SimpleXMLElement[]
     * @throws ErrorException
     */
    public function getIterator(string $tag_name): Generator
    {
        $plural_tag_name = Str::plural($tag_name);

        while (($is_success = $this->reader->read()) && !$this->isTagStarted($plural_tag_name)) continue;

        if (!$is_success) {
            throw new ErrorException('XMLReader::read(): incorrect feed format');
        }

        while (($is_success = $this->reader->read()) && !$this->isTagEnded($plural_tag_name)) {
            if ($this->isTagStarted($tag_name)) {
                yield $this->xml2array(simplexml_load_string($this->reader->readOuterXml()));
            }
        }

        if (!$is_success) {
            throw new ErrorException('XMLReader::read(): incorrect feed format');
        }
    }

    /**
     * @param string $tag_name
     * @return bool
     */
    private function isTagStarted(string $tag_name): bool
    {
        return $this->reader->nodeType === XMLReader::ELEMENT && $this->reader->name === $tag_name;
    }

    /**
     * @param string $tag_name
     * @return bool
     */
    private function isTagEnded(string $tag_name): bool
    {
        return $this->reader->nodeType === XMLReader::END_ELEMENT && $this->reader->name === $tag_name;
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
