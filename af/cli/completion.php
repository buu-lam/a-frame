<?php
namespace af\cli;
/**
 * Description of completion
 *
 *
 * nodes:
 */
class completion extends \node
{
    public function run($params)
    {
        if (!is_dir(\af\fullpath('/cli/')))
        {
            $this->dad->out("completion : cli doesn't exist or isn't a folder (af's extension ?).", 'f00');
        }
        else
        {
            $path   =   '/cli/'.\trim($params[0], '/');

            if (\af\file_exists($path, ''))
            {
                $this->dad->out("completion : $path already exists.", 'f00');
            }
            else if (\af\mkdir($path))
            {
                $this->dad->out("completion : $path created.", '0f0');
            }
            else
            {
                $this->dad->out("completion : $path error.", 'f00');
            }
        }
    }
}

