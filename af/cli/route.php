<?php
namespace af\cli;
/**
 * Description of route
 */
class route extends \node
{
    public function run($params)
    {
        $path   =   $params[0];
        $route  =   isset($params[1]) ? $params[1] : $path;
        $nodes  =   explode('/', $path);
        
        array_unshift($nodes, 'route');
        $dir    =   '';
        
        foreach($nodes as $node)
        {
            $dir    .=  '/' . $node;
            $this->dad->dir->run(array($dir));
            
            
            $has_dad    =   ($dir != '/route');
            
            $this->dad->file->run(array($dir.'/dot.php',
"<?php /* @var \$this \\app *//* @var \$app \\app */\n".
($has_dad ? "include dirname(__DIR__).'/dot.php';\n" : '').
"\$this->dot(__DIR__);
"
            ));
        
            $this->dad->file->run(array($dir.'/index.php',
"<?php /* @var \$this \\app *//* @var \$app \\app */
/** 
 * @route   $route
 * @path    $dir/index.php 
 */
include __DIR__.'/dot.php';

"
            ));
        }
        
        $this->dad->completion->run(array($path));
    }
}

