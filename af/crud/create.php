<?php
namespace af\crud;

/**
 * Description of create
 *
 *
 * nodes:
 */
class create extends \node
{
    public function url()
    {
        return $this->dad->url . '/create';
    }
}
