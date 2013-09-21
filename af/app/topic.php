<?php
namespace af\app;

/**
 * Description of topic
 *
 * @author ble
 */
class topic extends viewpath {
    
     public function set4Current($file)
     {
        return $this->set(
            $this->app->fileinfos->$file->route
        );
     }
     
     public function _404()
     {
         $this->set('_404');
         return $this;
     }
}
