<?php

namespace getjump\Vk\Wrapper;

use getjump\Vk\RequestTransaction;
use getjump\Vk\Response\Api;

/**
 * Class User
 * Implements user part of API.
 * @package getjump\Vk\Wrapper
 */
class User extends BaseWrapper
{


    /**
     * Get user with $userId
     * @param $userId
     * @param bool|array $fields
     * @return RequestTransaction|Api
     */
    public function get($userId, $fields = false)
    {
        if (is_array($userId)) {
            $userId = implode(',', $userId);
        }

        return $this->vk->param('user_ids', $userId)
            ->param('fields', $this->fieldsToString($fields), null)
            ->createAs(function ($d) {
                return new \getjump\Vk\Model\User($d);
            })
            ->request('users.get');
    }

    /**
     * @param bool|array $data
     * @return bool|string
     */
    public function fieldsToString($data = false)
    {
        if (!is_array($data)) {
            return false;
        }
        return implode(',', $data);
    }
}
