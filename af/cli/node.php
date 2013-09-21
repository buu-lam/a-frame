<?php
namespace af\cli;
/**
 * Description of class
 *
 * @author ble
 * nodes:
 */
class node extends \node 
{
    public function run($params)
    {
        $path   =   \trim($params[0], '/');
        $extend =   \af\path2class(isset($params[1]) ? $params[1] : '/node');
        
        $explode    =   \explode('/', $path);
        $full       =   \implode('\\', $explode);
        $class      =   \array_pop($explode);
        $namespace  =   \implode('\\', $explode);
        
        $this->dad->file->run(array(
            $path . '.php',
"<?php\n".
($namespace ? "namespace $namespace;\n": "")."
/**
 * Description of $class
 *
 *
 * nodes:
 */
class $class extends $extend
{

}

"
        ));
        
        $this->dad->completion->run(array($path));  
        
        $dad_path   =   \implode('/', $explode);
        
        if (\af\file_exists($dad_path))
        {
            $dad_content    =   \af\file_get_contents("$dad_path.php");
            $regex = "~@property ".str_replace('\\', '\\\\', $full)." \\$$class~";
            
            if (false === strpos($dad_content, " * nodes:"))
            {
                $this->dad->out("tag 'nodes:' not found, property $full not created", 'f00');
            }
            else if (\preg_match($regex, $dad_content))
            {
                $this->dad->out("existing property $class in $dad_path", 'f00');
            }
            else
            {
                \af\file_put_contents("$dad_path.php", \str_replace(
                    'nodes:', 
                    "nodes:\n * @property \\$full \$$class", 
                    $dad_content
                ));
                $this->dad->out("property \$$class created in $dad_path", '0f0');
            }
        }
        
    }
}
