<?php

namespace getjump\Vk;

/**
 * Class Auth
 * @package getjump\Vk
 */
class Auth
{
    const URL_ACCESS_TOKEN = 'https://oauth.vk.com/access_token?client_id=%s&client_secret=%s&code=%s&redirect_uri=%s';

    /**
     * @var \GuzzleHttp\Client
     */
    public $guzzle = false;

    private $options = [];

    /**
     * @param bool $options
     */
    public function __construct($options = false)
    {
        if (is_array($options)) {
            $this->options = $options;
        }
        $this->options['response_type'] = 'code';
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->options['client_id'];
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setAppId($id)
    {
        $this->options['client_id'] = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->options['client_secret'];
    }

    /**
     * @param string $secret
     * @return $this
     */
    public function setSecret($secret)
    {
        $this->options['client_secret'] = $secret;

        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->options['redirect_uri'];
    }

    /**
     * @param string $uri
     * @return $this
     */
    public function setRedirectUri($uri)
    {
        $this->options['redirect_uri'] = $uri;

        return $this;
    }

    /**
     * @param $scope
     * @return $this
     */
    public function setScope($scope)
    {
        $this->options['scope'] = $scope;

        return $this;
    }

    /**
     * @param $v
     * @return $this
     */
    public function setVersion($v)
    {
        $this->options['v'] = $v;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return sprintf('https://oauth.vk.com/authorize?%s', http_build_query($this->options));
    }

    /**
     * Just an alias, for an array
     * @param $d
     * @return mixed
     */
    public function g($d)
    {
        return $this->options[$d];
    }

    /**
     * Will return token if everything is OK
     * @return \getjump\Vk\Response\Auth|bool|string
     */
    public function startCallback()
    {
        if (isset($_GET['code'])) {
            $token = $this->getToken($_GET['code']);

            return $token;
        } elseif (isset($_GET['error'])) {
            //blah blah
        }

        return false;
    }

    /**
     * Method converts code to token
     * @param $code
     * @return \getjump\Vk\Response\Auth|bool
     */
    public function getToken($code)
    {
        if (!$this->guzzle) {
            $this->guzzle = new \GuzzleHttp\Client();
        }

        $uri = sprintf(
            self::URL_ACCESS_TOKEN,
            $this->g('client_id'),
            $this->g('client_secret'),
            $code,
            urlencode($this->g('redirect_uri'))
        );

        $data = $this->guzzle->get($uri)->json(['object' => true]);

        if (isset($data->access_token)) {
            return new \getjump\Vk\Response\Auth($data->access_token, $data->expires_in, $data->user_id);
        } elseif (isset($data->error)) {
            // ERROR PROCESSING
        }

        return false;
    }

    /**
     * @return Auth
     */
    public static function getInstance()
    {
        return new self;
    }
}
