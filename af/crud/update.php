<?php
namespace af\crud;

/**
 * Description of update
 *
 *
 * nodes:
 */
class update extends \node
{
    public function url()
    {
        return $this->dad->url . '/' . $this->data['id'];
    }
}

