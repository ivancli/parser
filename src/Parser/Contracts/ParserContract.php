<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 8/11/2017
 * Time: 11:25 PM
 */

namespace IvanCLI\Parser\Contracts;


abstract class ParserContract implements ParserInterface
{
    protected $content;
    protected $options = [];

    /**
     * set content property
     * @param $content
     * @return mixed
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * set options property needed for extraction.
     * @param $options
     * @return mixed
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }
}