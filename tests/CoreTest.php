<?php

class CoreTest extends PHPUnit_Framework_TestCase
{
    public function testCore()
    {
        $x = function () {
            return 'test';
        };
        $vk = \getjump\Vk\Core::getInstance()->apiVersion('5.5')->createAs($x);
        $this->assertInstanceOf('\getjump\Vk\Core', $vk);
        $rT = $vk->request('users.get', ['user_id' => 1]);
        $this->assertInstanceOf('\getjump\Vk\RequestTransaction', $rT);
        $js = $rT->toJs();
        $this->assertInstanceOf('\getjump\Vk\VkJs', $js);
        $this->assertInstanceOf('\getjump\Vk\RequestTransaction', $js->execute());
    }
}
 