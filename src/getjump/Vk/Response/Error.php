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
    public $error_msg;
    public $error_code;
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
