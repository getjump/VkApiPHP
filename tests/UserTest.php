<?php

class UserTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $vk = new \getjump\Vk\Core();
        $user = new \getjump\Vk\Wrapper\User($vk->apiVersion('5.21'));
        $obj = $user->get(1)->response->data[0];
        $this->assertInstanceOf('\getjump\Vk\Model\User', $obj);
        $this->assertEquals(1, $obj->id);
    }
}