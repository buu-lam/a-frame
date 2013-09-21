<?php
namespace af\cli;

/**
 * Description of module
 *
 *
 * nodes:
 */
class module extends \node
{
    public function run($params)
    {
        $module =   '/module/'.$params[0];
        
        $this->dad->node->run(array($module, '/module'));
        $this->dad->dir->run(array($module));
        $this->dad->node->run(array("$module/controller", '/app/controller'));
        
        $this->dad->dir->run(array("$module/"));
    }
}

