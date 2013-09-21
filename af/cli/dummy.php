<?php
namespace af\cli;
/**
 * Description of dummy
 *
 *
 * nodes:
 */
class dummy extends \node
{
    public function run($params)
    {
        $level  =   'af';
        chdir(\af::$fwk_dir);
        
        while ($files = glob($pattern = ($level .= '/*').'.php'))
        {
            $this->dad->out($pattern);
            
            foreach($files as $file)
            {
                $this->dad->out($file);
                $content    =   file_get_contents($file);
                $path       =   substr($file, 0, -4);
                $this->dad->out($path);
                if (strpos($content, 'class ') !== false)
                {
                    $dummy  =   preg_replace('~(^af/)~', '__/', $file);
                    $this->dad->out($dummy);
                    $namespace = substr(dirname($path), 3);
                    $this->dad->out($namespace);
                    
                    $data   =   
                        "<?php\n".
                       ($namespace ? ("namespace ".\af\path2class($namespace).";\n") : '').
                        "class " . \basename($path) . ' extends \\' . \af\path2class($path) . " {}\n"
                    ;
                    $this->dad->out($data);
                    \mkdir(dirname(\af::$fwk_dir.'/'.$dummy));
                    \file_put_contents(\af::$fwk_dir.'/'.$dummy, $data);
                }
            }
        }
        
        $this->out('done');
    }
}

