<?php

namespace getjump\Vk;

/**
 * Class Auth.
 */
class Auth
{
    const URL_ACCESS_TOKEN = 'https://oauth.vk.com/access_token?';

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
     *
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
     *
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
     *
     * @return $this
     */
    public function setRedirectUri($uri)
    {
        $this->options['redirect_uri'] = $uri;

        return $this;
    }

    /**
     * @param $scope
     *
     * @return $this
     */
    public function setScope($scope)
    {
        $this->options['scope'] = $scope;

        return $this;
    }

    /**
     * @param $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->options['state'] = $state;

        return $this;
    }

    /**
     * @param $v
     *
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
     * Just an alias, for an array.
     *
     * @param $d
     *
     * @param $default
     *
     * @return mixed
     */
    public function g($d, $default = null)
    {
        return isset($this->options[$d]) ? $this->options[$d] : $default;
    }

    /**
     * Will return token if everything is OK.
     *
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
     * Method converts code to token.
     *
     * @param $code
     *
     * @return \getjump\Vk\Response\Auth|bool
     */
    public function getToken($code)
    {
        if (!$this->guzzle) {
            $this->guzzle = new \GuzzleHttp\Client();
        }


        $params = [
            'client_id'     => $this->g('client_id'),
            'client_secret' => $this->g('client_secret'),
            'code'          => $code,
            'redirect_uri'  => $this->g('redirect_uri'),
            'state'         => $this->g('state'),
        ];

        $params = array_filter($params, function ($value) {
            return strlen($value) > 0;
        }, ARRAY_FILTER_USE_BOTH);

        if (!isset($params['client_id'], $params['client_secret'], $params['code'], $params['redirect_uri'])) {
            throw new \InvalidArgumentException('Params client_id, client_secret, code and redirect_uri is required.');
        }

        $uri = self::URL_ACCESS_TOKEN . http_build_query($params);

        $data = $this->guzzle->get($uri)->getBody();
        $data = json_decode($data);

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
        return new self();
    }
}
