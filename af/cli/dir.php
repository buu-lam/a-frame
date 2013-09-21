<?php
namespace af\cli;
/**
 * Description of dir
 */
class dir extends \node
{
    public function run($params)
    {
        $path       =   \trim($params[0], '/');
        $fullpath   =   \af\fullpath($path);
        
        if (\af\file_exists($path, ''))
        {
            $this->dad->out("folder : $fullpath exists", 'F00');
        }
        else
        {
            \af\mkdir($path);
            $this->dad->out("folder : $fullpath created", '0F0');
        }
        
    }
}

