<?php
namespace af\cli;
/**
 * Description of file
 */
class file extends \node
{
    public function run($params)
    {
        list($path, $data)   = $params;
        $fullpath   =   \af\fullpath($path);
        
        if (\af\file_exists($path, ''))
        {
            $this->dad->out("file : $fullpath exists", 'F00');
        }
        else
        {
            \af\file_put_contents($path, $data);
            $this->dad->out("file : $fullpath created", '0F0');
        }
        
    }
}

