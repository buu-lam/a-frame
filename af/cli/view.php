<?php
namespace af\cli;
/**
 * Description of view
 */
class view extends \node
{
    public function run($params)
    {
        $view   = \trim($params[0], '/');
        $parent = isset($params[1]) ? $params[1] : '\\view';
        
        $this->dad->node->run(array(
            "view/$view", $parent
        ));
        
        $this->dad->completion->run(array($view));
    }
}

