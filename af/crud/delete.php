<?php
namespace af\crud;

/**
 * Description of delete
 *
 *
 * nodes:
 */
class delete extends \node
{
    public function url()
    {
        return $this->dad->url . '/' . $this->data['id'] . '/delete';
    }
}

