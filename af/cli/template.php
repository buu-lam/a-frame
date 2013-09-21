<?php
namespace af\cli;
/**
 * Description of template
 */
class template extends \node
{
    public function run($params)
    {
        list($path) =   $params;
        $path       =   \trim($path, '/');
        $view       =   '\\view\\'.\af\path2class($path);
        $this->dad->file->run(array(
            "template/$path.php",
            "<?php /* @var \$this $view */ ?>\n\n"
        ));
        
        $this->dad->completion->run(array($path));
    }
}

