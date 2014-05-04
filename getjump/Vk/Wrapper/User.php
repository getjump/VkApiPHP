<?php

namespace getjump\Vk\Wrapper;


class User extends BaseWrapper {

    const
        FIELD_SEX = 1,
        FIELD_PHOTO_MAX_ORIG = 2;

    public function get($userId, $fields = false) {
        if(is_array($userId)) $userId = implode(',', $userId);
        return $this->vk
            ->param('user_ids', $userId)
            ->param('fields', $this->fieldsToString($fields), null)
            ->createAs(function($d) { return new \getjump\Vk\Model\User($d); })
            ->request('users.get');
    }

    public function fieldsToString($bitmask)
    {
        $string = array();
        if($bitmask & self::FIELD_SEX) $string[] = 'sex';
        if($bitmask & self::FIELD_PHOTO_MAX_ORIG) $string[] = 'photo_max_orig';
        return implode(',', $string);
    }
} 