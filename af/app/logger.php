<?php

namespace af\app;

/**
 * Description of logger
 *
 *
 * nodes:
 */
class logger extends \node
{
    /**
     *
     * @var string namespace
     */
    protected $trackvar  = 'logger';
    
    public $isLogging = false;
    public $onLogging = false;
    public $fields_match = array('login' => false, 'pass'  => false);

    public function model()
    {
        return $this->app->user;
    }
    
    public function isLogged()
    {
        return isset($this->track->{$this->trackvar});
    }

    public function login($data)
    {
        if (($login = array_intersect_key($data, $this->fields_match))
            && count(array_filter($login)) == count($this->fields_match))
        {
            $this->isLogging = true;

            if (($logger = $this->getMatch($login)))
            {
                $this->track->{$this->trackvar} = $this->track_id($logger);
                $this->value         = $logger;
            }
        }

        return $this;
    }

    public function success()
    {
        
    }
    
    public function fail()
    {
        
    }
    
    public function track()
    {
        return new \track;
    }
    
    public function track_id($logger)
    {
        return $logger['_id'];
    }
    
    public function getMatch($data)
    {
        return $this->model->findOne($data);
    }

    public function value()
    {
        return $this->isLogged ?
            $this->model->get4Id($this->track->{$this->trackvar}) : null
        ;
    }

    public function logout()
    {
        unset($this->track->{$this->trackvar});
        return $this;
    }
}

