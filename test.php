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
$vk->createAs(
    function ($data) {
        return new \getjump\Vk\Model\Wall($data);
    }
);
/**
 * @var $wall \getjump\Vk\Model\Wall
 */
$wall = $vk->request(
    'wall.getById',
    ['posts' => '-32295218_159462', 'extended' => 1, 'copy_history_depth' => 5]
)->one();
print $wall->getId() . PHP_EOL;

$i = 0;

while (($d=$wall->getSource($i)) !== false) {
    print $d->getId() . PHP_EOL;
    $i++;
}
