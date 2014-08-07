<?php

require 'vendor/autoload.php';

/*
use getjump\Vk\Constants\UserFields as U;
$user = new \getjump\Vk\Wrapper\Friends(\getjump\Vk\Core::getInstance()->apiVersion('5.5')->setLang('en'));

$user->get(15157875, [U::FIRST_NAME, U::LAST_NAME, U::STATUS])
    ->each(
        function ($i, \getjump\Vk\Model\User $user) {
            if (($status=$user->getStatus()) != "")
            {
                if(($audio=$user->getStatusAudio()) !== false)
                {
                    printf("%s is listening for %s" . PHP_EOL, $user->getName(), $audio->getName());
                    print $audio->getUrl() . PHP_EOL;
                }
            }
        }
    );
*/

$vk = \getjump\Vk\Core::getInstance()->setLang('en')->apiVersion('5.21');

$friends = $vk->request('friends.get', ['user_id' => 1, 'fields' => 'first_name, last_name']);

foreach($friends->batch(100) as $friend)
{
    $friend->each(function($k, $v) {
        var_dump($v);
    });
}