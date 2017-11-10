<?php
/**
 * Created by PhpStorm.
 * User: ivan.li
 * Date: 20/06/2017
 * Time: 10:51 AM
 */

namespace IvanCLI\Parser\Repositories;


use IvanCLI\Parser\Contracts\ParserContract;

class ArrayParser extends ParserContract
{
    protected $json_content;

    /**
     * extract data from provided content
     * @return mixed
     */
    public function extract()
    {
        $this->__jsonize();
        $extractions = [];
        foreach ($this->options as $key => $arrays) {
            if (is_array($arrays)) {
                $extractions[$key] = [];
                foreach ($arrays as $array) {
                    $result = $this->__arrayGet($array);
                    if (!is_null($result)) {
                        $extractions[$key][] = $result;
                    }
                    unset($result);
                }
            } else {
                $result = $this->__arrayGet($arrays);
                if (!is_null($result)) {
                    $extractions[$key][] = $result;
                }
                unset($result);
            }
        }
        return $extractions;
    }

    private function __arrayGet($array)
    {
        $levels = explode('.', $array);
        $attribute = $this->json_content;
        $valid = true;
        foreach ($levels as $key) {
            if (is_object($attribute)) {
                if (isset($attribute->$key)) {
                    $attribute = $attribute->$key;
                } else {
                    $valid = false;
                    break;
                }
            } elseif (is_array($attribute)) {
                if (isset($attribute[$key])) {
                    $attribute = $attribute[$key];
                } else {
                    $valid = false;
                    break;
                }
            } else {
                $valid = false;
                break;
            }
        }
        if ($valid == true) {
            return $attribute;
        }
        return null;
    }

    private function __jsonize()
    {
        if (!is_null($this->content) && !empty($this->content)) {
            $json_content = json_decode($this->content);
            if (!is_null($json_content) && json_last_error() === JSON_ERROR_NONE) {
                $this->json_content = $json_content;
                return true;
            }
        }
        return false;
    }
}