<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 03.05.14
 * Time: 12:19
 */

namespace getjump\Vk;


class RequestTransaction {

    public $init = false;

    public $worker = false;

    /**
     * @var \GuzzleHttp\Client
     */
    public $guzzle = false;

    private $accessToken = false;

    public $methodName = false;
    public $args = array();
    public $callback = false;

    /**
     * @param $methodName
     * @param bool $args
     * @param bool $callback
     * @return Response
     */
    public function __construct($methodName, $args = false, $accessToken = false, $callback = false)
    {
        $this->methodName = $methodName;
        $this->args = $args;
        $this->accessToken = $accessToken;
        $this->callback = $callback;
    }

    public function batch($count = 10)
    {
        $this->args['count'] = $count;
        $this->args['offset'] = 0;

        while(true)
        {
            $d = $this->fetchData();
            yield $d;
            $everything = $d->response->count;
            $this->args['offset'] += $count;
            if($this->args['offset'] >= $everything) break;
            //isset($this->args['offset']) ? $this->args['offset'] += $count : $this->args['offset'] = 0;
        }
    }

    public function __get($name)
    {
        if(!$this->init)
        {
            return $this->fetchData()->$name;
        }

        return false;
    }

    function __call($name, $arguments)
    {
        if(!$this->init)
        {
            return call_user_func_array([$this->fetchData(), $name], $arguments);
        }

        return false;
    }

    public function fetchData()
    {
        if(!$this->guzzle)
        {
            $this->guzzle = new \GuzzleHttp\Client();
        }

        $args = $this->args;

        if($this->accessToken) $args['access_token'] = $this->accessToken;

        $c = new ApiResponse($this->guzzle->post('https://api.vk.com/method/'.$this->methodName, ['body' => $args])->json(['object' => true]), $this->callback);
        //$c = new ApiResponse(json_decode(file_get_contents('https://api.vk.com/method/'.$this->methodName.'?'.$query)), $this->callback);
        return $c;
    }


    public function execute()
    {
        $this->fetchData();
    }

    public function toJs()
    {
        return new VkJs($this->methodName, $this->args, Core::getInstance());
    }
} 