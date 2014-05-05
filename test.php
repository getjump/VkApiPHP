<?php

header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';
require 'getjump/Vk/Core.php';
require 'getjump/Vk/RequestTransaction.php';
require 'getjump/Vk/Wrapper/BaseWrapper.php';
require 'getjump/Vk/Response/Api.php';
require 'getjump/Vk/Response/Response.php';
require 'getjump/Vk/Response/Error.php';
require 'getjump/Vk/Wrapper/LongPoll.php';
require 'getjump/Vk/Wrapper/User.php';
require 'getjump/Vk/Wrapper/Friends.php';
require 'getjump/Vk/Model/BaseModel.php';
require 'getjump/Vk/Model/Friends.php';
require 'getjump/Vk/Model/User.php';
require 'getjump/Vk/VkJs.php';

$vk = getjump\Vk\Core::getInstance()
    ->apiVersion('5.5')
    ->setToken('c4333e8a6791563ea23fea1480131371a80822e032f5e7deca27254e21cf8e9da6902f24f2e9b58653fae');

$lp = new \getjump\Vk\Wrapper\LongPoll($vk);

$user = new \getjump\Vk\Wrapper\User($vk);
$friends = new \getjump\Vk\Wrapper\Friends($vk);

////$js1 = $friends->get(1, 'first_name, last_name, photo_100')->toJs();
////$js2 = $friends->get(2, 'first_name, last_name, photo_100')->toJs();
//
//$vk->createAs(function($data) {
//    return new \getjump\Vk\Model\BaseModel($data);
//});
//
//$count = 0;
//
//for($i = 0; $i < 4; $i = $i + 4)
//{
//    printf("<h1>%s</h1>", $i);
    $js1 = $vk->request('messages.get', ['count' => 200, 'offset' =>0*200])->toJs();
    $js2 = $vk->request('messages.get', ['count' => 200, 'offset' =>1*200])->toJs();
    $js3 = $vk->request('messages.get', ['count' => 200, 'offset' =>2*200])->toJs();
    $js4 = $vk->request('messages.get', ['count' => 200, 'offset' =>3*200])->toJs();

    //var_dump($js1->append($js2)->append($js3)->append($js4)->execute());
    $js1
        ->append($js2)
        ->append($js3)
        ->append($js4)
        ->execute()
        ->each(
            function($i, $v)
            {
                /**
                 * @var $v \getjump\Vk\Response\Api
                 */
                $v->each(function($c, $d) {
                    if(isset($d->body)) print $d->body . '<br>';
                });
            });
//print $count;
//
$friends
    ->get(15157875, 'first_name, last_name')
    ->toJs()->execute()->response->each(
        function($i, $v) {
            print $v->getName() . '<br>';
        });

//$lp->doLoop();
