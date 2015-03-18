<?php
namespace getjump\Vk\Model;

/**
 * Class User
 * Just a User Model
 * @package getjump\Vk\Model
 */
class User extends BaseModel
{
    /**
     * Return users first name and second name that concatenated with space
     * @return string
     */
    public function getName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Return users status
     * @return Status
     */
    public function getStatus()
    {
        return new Status($this->status);
    }

    /**
     * Return user mobile phone
     * @return string|bool
     */
    public function getMobile()
    {
        return $this->mobile_phone;
    }

    /**
     * Return user home phone
     * @return string|bool
     */
    public function getPhone()
    {
        return $this->home_phone;
    }

    /**
     * Return true if user has mobile
     * @return bool
     */
    public function hasMobile()
    {
        return $this->has_mobile;
    }
}
