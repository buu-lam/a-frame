<?php
namespace af;

/**
 * Description of config
 *
 *
 * nodes:
 */
class config extends \node
{   
    public function filepath($extension)
    {
        return  \af::$app_dir . '/config.' . $extension;
    }
    /**
     * 
     * @return type
     */
    public function manual()
    {
        return array();
    }
    
    /**
     * ini files
     * @return assoc
     */
    public function ini()
    {
         return parse_ini_file($this->filepath(__FUNCTION__), true);
    }
    
    /**
     * php files
     * @return assoc
     */
    public function php()
    {
        include $this->filepath(__FUNCTION__);
    }
    
    public function spyc_yml_file()
    {
        return Spyc::YAMLLoad($this->filepath('yml'));
    }
    
    public function spyc_yml_php()
    {
        ob_start();
        include $this->filepath('yml');
        $o  =   ob_get_clean();
        return Spyc::YAMLLoadString($o);
    }
}

