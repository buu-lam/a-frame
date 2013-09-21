<?php
namespace af\cli;
/**
 * Description of mail
 */
class mail extends \node
{
public function run($params)
    {
        $path   =   \trim($params[0], '/');
        
        $this->dad->file->run(array(
            '/mail/'.$path.'.yml',
"---
charset:  utf-8
from:     
to:       
cc:       
bcc:      
subject:  
body:     |
          

"
        ));
        
        $this->dad->completion->run(array($path));
    }
}

