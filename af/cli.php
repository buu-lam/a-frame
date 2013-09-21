<?php

namespace af;

/**
 * Description of cli
 *
 * @author b.le
 * nodes:
 * @property af\cli\infos $infos
 * @property af\cli\view $view
 * @property af\cli\template $template
 * @property af\cli\tpl $tpl
 * @property af\cli\url $url
 * @property af\cli\route $route
 * @property af\cli\mail $mail
 * @property af\cli\help $help
 * @property af\cli\file $file
 * @property af\cli\dir $dir
 * @property af\cli\completion $completion
 * @property af\cli\node $node
 * @property af\cli\module $module
 * 
 */
class cli extends \node {

    protected $utf8;
    public $colors = array(
        'def' => '00',
        '000' => '30',
        'f00' => '31','F00' => '31',
        '0f0' => '32','0F0' => '32',
        'ff0' => '33','FF0' => '33',
        '00f' => '34','00F' => '34',
        '0ff' => '35','0FF' => '35',
        'f0f' => '36','F0F' => '36',
        'fff' => '37','FFF' => '37',
    );
    
    /**
     * used to fix output display (linux / cygwin)
     * @param bool $boo
     * @return \af\cli
     */
    public function utf8($boo) {
        $this->utf8 = $boo;
        return $this;
    }

    public function run($params) {
          
        if (($arg = \trim(array_shift($params), '/')) == 'cli')
        {
            $arg = \trim(array_shift($params), '/');
        }
        if (($action = $this->$arg)
                && method_exists($action, 'run')) {
            $action->run($params);
        }
        else
        {
            $this->out("$arg inexistant");
            var_dump($params);
        }
    }

    public function out($text, $color = 'def', $lf = true) {
        echo "\033[{$this->colors[$color]}m",
        $this->utf8 ? $text : \utf8_decode($text),
        $lf ? "\n" : '',
        "\033[00m";
        return $this;
    }
    
    public function view($dummypath = '')
    {
        $class = $this->_class . '\\view';
        return ($this->view = new $class($this));
    }
}
