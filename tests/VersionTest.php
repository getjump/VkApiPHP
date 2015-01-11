<?php

class VersionTest extends PHPUnit_Framework_TestCase {
    public function testVersion()
    {
        $vk = new \getjump\Vk\Core();
        $vk->apiVersion('5.27');
        $v1 = $v2 = false;
        try {
            $vk->request('users.get')->one();
        } catch(\getjump\Vk\Exception\Error $e)
        {
            foreach($e->error->request_params as &$p)
            {
                if($p->key == 'v')
                {
                    $v1 = $p->value;
                    break;
                }
            }
            $this->assertEquals(113, $e->getCode());
        }
        try {
            $obj2 = $vk->request('users.get')->one();
        } catch(\getjump\Vk\Exception\Error $e)
        {
            foreach($e->error->request_params as &$p)
            {
                if($p->key == 'v')
                {
                    $v2 = $p->value;
                    break;
                }
            }
            $this->assertEquals(113, $e->getCode(), 'Error code doesn\'t equal');
            $this->assertEquals('5.27', $v1);
            $this->assertEquals('5.27', $v2);
        }
    }
}
