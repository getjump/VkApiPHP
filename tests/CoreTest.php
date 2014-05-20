<?php

class CoreTest extends PHPUnit_Framework_TestCase
{
    public function testCore()
    {
        $x = function () {
            return 'test';
        };
        $vk = \getjump\Vk\Core::getInstance()->apiVersion('5.5')->setToken('test')->createAs($x);
        $this->assertInstanceOf('\getjump\Vk\Core', $vk);
        $rT = $vk->request('test');
        $this->assertInstanceOf('\getjump\Vk\RequestTransaction', $rT);
        $this->assertArrayHasKey('v', $rT->args);
        $js = $rT->toJs();
        $this->assertInstanceOf('\getjump\Vk\VkJs', $js);
        $this->assertInstanceOf('\getjump\Vk\RequestTransaction', $js->execute());
    }
}
 