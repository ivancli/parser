<?php
/**
 * Created by PhpStorm.
 * User: ivan.li
 * Date: 16/06/2017
 * Time: 12:02 PM
 */

namespace IvanCLI\Parser\Repositories;


use IvanCLI\Parser\Contracts\ParserContract;

class RegexParser extends ParserContract
{

    /**
     * extract data from provided content
     * @return mixed
     */
    public function extract()
    {
        $extractions = [];
        foreach ($this->options as $key => $regexes) {
            if (is_array($regexes)) {
                $extractions[$key] = [];
                foreach ($regexes as $regex) {
                    $result = $this->__pregMatch($regex);
                    if (!is_null($result)) {
                        $extractions[$key][] = $result;
                    }
                    unset($result);
                }
            } else {
                $result = $this->__pregMatch($regexes);
                if (!is_null($result)) {
                    $extractions[$key][] = $result;
                }
                unset($result);
            }
        }

        return $extractions;
    }

    private function __pregMatch($regex)
    {
        preg_match($regex, $this->content, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        }
        return null;
    }
}