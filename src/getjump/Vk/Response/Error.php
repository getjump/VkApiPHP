<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 02.05.14
 * Time: 16:19
 */

namespace getjump\Vk\Response;

use getjump\Vk\Exception;

/**
 * Class Error
 * @package getjump\Vk\Response
 */
class Error
{
    /**
     * Will contain error message from Vk
     * @var
     */
    public $error_msg;
    /**
     * Will contain error code from Vk
     * @var
     */
    public $error_code;
    /**
     * Will contain request params from Vk
     * @var array
     */
    public $request_params = array();

    /**
     * @param $error
     * @throws Exception\Error
     */
    public function __construct($error)
    {
        foreach($error as $k => $v)
            $this->{$k} = $v;
        throw new Exception\Error($error->error_msg, $error->error_code, $this);
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->error_code;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->error_msg;
    }

    /**
     * @return array
     */
    public function getRequestParams()
    {
        return $this->request_params;
    }
}
