<?php
/**
 * Created by PhpStorm.
 * User: ivan.li
 * Date: 3/13/2017
 * Time: 4:27 PM
 */

namespace IvanCLI\Parser\Repositories;


use IvanCLI\Parser\Contracts\ParserContract;
use Symfony\Component\DomCrawler\Crawler;

class XPathParser extends ParserContract
{
    protected $crawler;

    /**
     * extract data from provided content
     * @return mixed
     */
    public function extract()
    {
        $this->__initCrawler();
        $extractions = [];
        foreach ($this->options as $key => $xpaths) {
            if (is_array($xpaths)) {
                $extractions[$key] = [];
                foreach ($xpaths as $xpath) {
                    $extractions[$key][] = $this->__filterByXpath($xpath);
                }
            } else {
                $extractions[$key][] = $this->__filterByXpath($xpaths);
            }
        }
        return $extractions;
    }

    /**
     * initialise crawler
     */
    private function __initCrawler()
    {
        $this->crawler = new Crawler($this->content);
    }

    /**
     *
     * @param $xpath
     * @return array
     */
    private function __filterByXpath($xpath)
    {
        $xpathNodes = $this->crawler->filterXPath($xpath);
        $extractions = [];
        foreach ($xpathNodes as $xpathNode) {
            if ($xpathNode->nodeValue) {
                $extraction = $xpathNode->nodeValue;
            } else {
                $extraction = $xpathNode->textContent;
            }
            $extractions[] = $extraction;
        }
        return $extractions;
    }
}