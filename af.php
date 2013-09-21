<?php
/**
 * Framework main class
 *
 * @author ble
 */
class af {
    
    /**
     * Application dirpath
     * @var string 
     */
    public static $app_dir;
    
    /**
     * Framework dirpath
     * @var string 
     */
    public static $fwk_dir;
    
    /**
     * Registered dirs for autoloading purposes
     * @var array|of|string 
     */
    protected static $autoload_dirs = array();
    /**
     * Framework bootstrap
     * @param string $app_dir
     * @param boolean $use_internal_loader
     */
    public static function boot($app_dir, $use_internal_loader = true)
    {
        self::$fwk_dir  =   __DIR__;
        spl_autoload_register(array('af', 'autoloadAlias'));

        if (!is_string($app_dir))
        {
            throw new af\exception('app_dir is not a string');
        }
         
        self::$app_dir  =   $app_dir;
        
        if ($use_internal_loader) {
            
            static::registerDirs($app_dir);
            
            if (file_exists($dirlib = "$app_dir/lib"))
            {
                static::registerDirs($dirlib);
            }
            
            spl_autoload_register(array('af', 'autoload'));
        }
    }
    
    /**
     * Registers a dir or list of dirs for autoloading purposes
     * @param array|string $dirs
     */
    public static function registerDirs($dirs)
    {
        foreach((array) $dirs as $dir)
        {
            static::$autoload_dirs[]  =   $dir;
        }
    }
    /**
     * Autoload handler
     * @param string $class
     * @return boolean
     */
    public static function autoload($class)
    {
        $path   =   '/' . \str_replace('\\', '/', $class) . '.php';
        
        if (\strpos($class, 'af\\') === 0)
        {
            if (\file_exists($file = (self::$fwk_dir . $path)))
            {
                include $file;
                return true;
            }
        }
        else 
        {   
            foreach(static::$autoload_dirs as $dir)
            {
                if (\file_exists($file = ($dir . $path)))
                {
                    include $file;
                    return true;
                }
            }
        }
        
        return false;
    }
    
    /**
     * All A-Frame classes can be extended by custom classes
     * that's why all a-frame classes inherit by extended
     * 
     * 
     * Les héritages des classes a-frame entre elles sont
     * architecturées de telle sorte que le développeur peut
     * à tout moment allonger la liste des parents
     * Dans un cas basique
     *   af\classA hériterait de af\classB
     * Dans a-frame
     *   af\classA hérite de classB, par défaut alias de af\classB
     * On peut alors imaginer
     *   af\classA hérite de classB personnalisé par le développeur
     *   héritant de classB2 héritant enfin de af\classB
     * Cette architecture permet d'étendre n'importe quelle classe A-Frame
     * sans avoir à étendre toutes les classes dépendantes
     * 
     * ainsi pour personnaliser af\app\header,
     * on crée une classe app\header liée à app 
     * sans avoir à créer une classe app
     * 
     * @param type $class
     * @return boolean
     */
    public static function autoloadAlias($class) 
    {   
        return 
            strpos($class, 'af\\') !== 0 &&
            class_exists($alias = 'af\\' . $class) &&
            class_alias($alias, $class)
        ;        
    }
}

include __DIR__ . '/af/functions.php';
