<?php

require 'vendor/autoload.php';

use getjump\Vk\Constants\UserFields as U;

$user = new \getjump\Vk\Wrapper\User(\getjump\Vk\Core::getInstance()->apiVersion('5.5')->setLang('en'));

$user->get(range(1, 500), [U::FIRST_NAME, U::LAST_NAME, U::VERIFIED])
    ->each(
        function ($i, \getjump\Vk\Model\User $user) {
            $i = $i + 1;
            print "#{$i} " . $user->getName();
            if ($user->verified) {
                print " [x]";
            }
            print PHP_EOL;
        }
    );
