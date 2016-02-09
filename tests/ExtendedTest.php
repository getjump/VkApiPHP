<?php

class ExtendedTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $vk = new \getjump\Vk\Core();
        $vk->apiVersion('5.22');

        $object = $vk->request('wall.get', ['owner_id' => 1, 'count' => 1, 'extended' => 1]);

        $extended = $object->response->extended();

        $this->assertEquals($extended->profiles[0]->id, 1);
    }
}
