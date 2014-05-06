<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 02.05.14
 * Time: 17:19
 */

namespace getjump\Vk\Wrapper;

class Friends extends BaseWrapper {

    const
        FIELD_SEX = 1,
        FIELD_PHOTO_MAX_ORIG = 2;

    /**
     * @param $userId
     * @param bool $fields
     * @return \getjump\Vk\Response\Api|\getjump\Vk\RequestTransaction
     */
    public function get($userId, $fields = false)
    {
        return $this->vk
            ->param('user_id', $userId)
            ->param('fields', $fields, null)
            ->param('order', 'hints')
            ->createAs(function($d) { return new \getjump\Vk\Model\User($d); })
            ->request('friends.get');
    }

    public function fieldsToString($bitmask)
    {
        $string = array();
        if($bitmask & self::FIELD_SEX) $string[] = 'sex';
        if($bitmask & self::FIELD_PHOTO_MAX_ORIG) $string[] = 'photo_max_orig';
        return implode(',', $string);
    }
} 