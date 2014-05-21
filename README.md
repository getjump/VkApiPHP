# Vk API PHP

[![Build Status](https://travis-ci.org/getjump/VkApiPHP.svg?branch=master)](https://travis-ci.org/getjump/VkApiPHP)

That library will help you organize your work with API Vk.com

## Installation

You can get library and all of it dependencies through [composer](https://getcomposer.org/)

`composer require "getjump/vk:*"`

## Explanation

Okay, that is how we can instantiate main object for our future requests

```php
$vk = getjump\Vk\Core::getInstance()->apiVersion('5.5')->setToken(>>> HERE YOUR TOKENS GOES <<<);
```

>YOU CAN GET SOME TOKENS AT : 
>You can get some tokens at:
>http://oauth.vk.com/authorize?client_id=3470411&scope=messages,photos,groups,status,wall,offline&redirect_uri=blank.html&display=page&v=5.5&response_type=token
>I can't steal them, since it's VK side stuff guys, scope means what rights you needed for, i recommend as much as you can, if you don't want problems.
If you wanna use site authorization, look at next snippet:

```php
$vk = getjump\Vk\Core::getInstance()->apiVersion('5.5');

$auth = getjump\Vk\Auth::getInstance();
$auth->setAppId('3470411')->setScope('SCOPE')->setSecret('SECRET CODE')->setRedirectUri('http://localhost/test.php'); // SETTING ENV
$token=$auth->startCallback(); // Here we will have token, if everything okay

printf("<a href='%s' target='_top'>LINK</a>", $auth->getUrl());
if($token) {
    $vk->setToken($token);
    $vk->request('users.get', ['user_ids' => range(1, 100)])->each(function($i, $v) {
        if($v->last_name == '') return;
        print $v->last_name . '<br>';
    });
}
```

I already did some wrappers just for you, if you wanna more, please do and pull request but you still can don't use them, or use something like this.

```php
$vk->request('friends.get', ['user_id' => '15157875'])->each(function($i, $v) {});
```

That us long polling shiet, it works like a hell, as fast as you can see.
```php
// Long pooling loop
$lp = new getjump\Vk\Wrapper\LongPoll($vk);
$lp->doLoop();
```

We will do badass stuff, like kiss. You can do like the following and it will works
```php
//KISS
$user=new getjump\Vk\Wrapper\User(getjump\Vk\Core::getInstance()->apiVersion('5.5'));
$user->get(1, 'photo_max_orig, sex'); //It will contain RequestTransaction, and will wait for your action, like getting response ->response or calling ->each(callback)
//Since __get and __call are overrided, we will request for a data, only when it neeeded
```

We can use my own sakhalin technilogies and take all the stuff that VK have for that request using generators
```php
// Friends gets
$friends = new getjump\Vk\Wrapper\Friends($vk);
foreach($friends->get(15157875, 'first_name, last_name')->batch(100) as $f) //BATCH MEAN $f WILL CONTAIN JUST 100 ELEMENTS, AND REQUEST WILL MADE FOR 100 ELEMENTS
{
    /**
     * @var $f \getjump\Vk\ApiResponse;
     */
 
    $f->response->each(function($i, $j) {
        if(!$j->online) return;
        print $j->getName() . '<br>';
    });
}
```

But you still can do old style stuff
```php
 //SECOND OPTION TO JUST GET EVERYTHING, WITHOUT count BEING SEND
$friends->get(15157875, 'first_name, last_name')->response->each(function($i, $d) {
     if($d->online)
     {
         print $d->getName() . '<br>';
     }
});
```

That snippet will show you your last 200 messages
```php
//MESSAGES
$data = $vk->request('messages.get', ['count' => 200]);
 
$userMap = [];
$userCache = [];
 
$user = new \getjump\Vk\Wrapper\User($vk);
 
$fetchData = function($id) use($user, &$userMap, &$userCache)
{
    if(!isset($userMap[$id]))
    {
        $userMap[$id] = sizeof($userCache);
        $userCache[] = $user->get($id)->response->get();
    }
 
    return $userCache[$userMap[$id]];
};

//REQUEST WILL ISSUE JUST HERE! SINCE __get overrided
$data->each(function($key, $value) use($fetchData) {
    $user = $fetchData($value->user_id);
    printf("[%s] %s <br>", $user->getName(), $value->body);
    return;
});
```

Once more black magic. VK has method called execute, that can take something like JS code. Look what i've done for that.
```php
$js1 = $vk->request('messages.get', ['count' => 200, 'offset' =>0 * 200])->toJs(); //IT WILL RETURN VkJs object
$js2 = $vk->request('messages.get', ['count' => 200, 'offset' =>1 * 200])->toJs();
$js3 = $vk->request('messages.get', ['count' => 200, 'offset' =>2 * 200])->toJs();
$js4 = $vk->request('messages.get', ['count' => 200, 'offset' =>3 * 200])->toJs();


$js1
        ->append($js2) // WE ARE APPENDING js2 to js1
        ->append($js3)
        ->append($js4) 
        ->execute() // WE WANT EXECUTE THIS (actually it will return RequestTransaction)
        ->response //AS FOR NOW WE REALLY DO SOME REQUEST TO API 
        ->each(
            function($i, $v) //FIRST CALLBACK IS NEEDED TO GO FOR EVERY PART OF RESPONSE, ARRAY WITH 4-ELS IN OUR CASE
            {
                $v->each(function($c, $d) { // SECOND TO CHECK EVERY ELEMENTS IN ARRAY WITH 200 ELEMENTS
                    if(isset($d->body)) print $d->body; //WE JUST OUTPUTTING MESSAGE IF IT SET
                });
            });
            
```
