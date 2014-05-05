<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 05.05.14
 * Time: 19:04
 */

namespace getjump\Vk;


class Auth {
    /**
     * @var \GuzzleHttp\Client
     */
    public $guzzle = false;

    private $options = [];

    public function __construct($options = false) {
        if($options)
        {
            $this->options = $options;
        }
        $this->options['response_type'] = 'code';
    }

    public function getAppId() {
        return $this->options['client_id'];
    }

    public function setAppId($id) {
        $this->options['client_id'] = $id;
        return $this;
    }

    public function getSecret() {
        return $this->options['client_secret'];
    }

    public function setSecret($secret) {
        $this->options['client_secret'] = $secret;
        return $this;
    }

    public function getRedirectUri()
    {
        return $this->options['redirect_uri'];
    }

    public function setRedirectUri($uri)
    {
        $this->options['redirect_uri'] = $uri;
        return $this;
    }

    public function setScope($permissions)
    {
        $this->options['permissions'] = $permissions;
        return $this;
    }

    public function setVersion($v)
    {
        $this->options['v'] = $v;
        return $this;
    }

    public function getUrl()
    {
        return sprintf('https://oauth.vk.com/authorize?%s', http_build_query($this->options));
    }

    public function g($d)
    {
        return $this->options[$d];
    }

    public function startCallback()
    {
        if(isset($_GET['code']))
        {
            $token = $this->getToken($_GET['code']);
            return $token;
        } else if(isset($_GET['error']))
        {
            //blah blah
        }
        return false;
    }

    public function getToken($code)
    {
        if(!$this->guzzle)
        {
            $this->guzzle = new \GuzzleHttp\Client();
        }

        $uri = sprintf('https://oauth.vk.com/access_token?client_id=%s&client_secret=%s&code=%s&redirect_uri=%s',
            $this->g('client_id'),
            $this->g('client_secret'),
            $code,
            urlencode($this->g('redirect_uri'))
        );

        $data = $this->guzzle->get($uri)->json(['object' => true]);
        var_dump($data);
        if(isset($data->access_token))
        {
            // POSSIBLY WE SHOULD RETURN OBJECT, WITH USER_ID AND EXPIRES IN, NOT ONLY TOKEN
            return $data->access_token;
        } else if(isset($data->error))
        {
            // ERROR PROCESSING
        }
        return false;
    }

    public static function getInstance()
    {
        return new self;
    }
}