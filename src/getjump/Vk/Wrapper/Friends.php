<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 02.05.14
 * Time: 17:19
 */

namespace getjump\Vk\Wrapper;

use getjump\Vk\Model\User;
use getjump\Vk\RequestTransaction;
use getjump\Vk\Response\Api;

/**
 * Class Friends
 * Implements some logic for API part that working with friends
 * @package getjump\Vk\Wrapper
 */
class Friends extends BaseWrapper
{
    /**
     * Return friends of a user with $userId
     * @param int|string $userId
     * @param bool $fields
     * @return Api|RequestTransaction
     */
    public function get($userId, $fields = false)
    {
        return $this->vk->param('user_id', $userId)
            ->param('fields', $this->fieldsToString($fields), null)
            ->param('order', 'hints')
            ->createAs(function ($d) {
                return new User($d);
            })
            ->request('friends.get');
    }

    /**
     * @param $data
     * @return null|string
     * @todo Put this to another place (duplicate with User)
     */
    public function fieldsToString($data)
    {
        if (!$data) {
            return null;
        }
        return implode(',', $data);
    }
}
