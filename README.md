VkApiPHP
========

### VK API PHP, ALL NEW, MAY THE FORCE BE WITH YOU


HELLO GUYS AND THIS IS MY NEW VK LIBRARIES. IF YOU WANNA BE CHOTKIY POCIK, YOU SHOULD USE THIS FOR YOUR VK API REQUESTS.

I WILL SHOW WHAT YOU CAN DO WITH THIS STUFF

OKAY, THAT IS HOW WE CAN INSTANTIATE MAIN OBJECT FOR OUR FUTURE REQUESTS

YOU CAN GET SOME TOKENS AT : 

http://oauth.vk.com/authorize?client_id=3470411&scope=messages,photos,groups,status,wall,offline&redirect_uri=blank.html&display=page&v=5.5&response_type=token

I CAN'T STEAL THEM, SINCE IT'S VK SIDE STUFF GUYS, SCOPE MEANS WHAT RIGHTS YOU NEEDED FOR, I RECOMMEND AS MUCH AS YOU CAN, IF YOU DON'T WANT PROBLEMS.

```php
$vk = getjump\Vk\Core::getInstance()->apiVersion('5.5')->setToken(>>> HERE YOUR TOKENS GOES <<<);
```
 
 
I ALREADY DID SOME WRAPPERS JUST FOR YOU, IF YOU WANNA MORE, PLEASE DO AND PULL REQUEST

THAT IS LONG POLLING SHIET, IT WORKS LIKE A HELL, AS FAST AS YOU CAN SEE.
```php
//LONG POLLING LOOP
$lp = new getjump\Vk\Wrapper\LongPoll($vk);
$lp->doLoop();
```
 
WE WILL DO BADASS STUFF, LIKE KISS. YOU CAN DO LIKE THE FOLLOWING AND IT WILL WORKS
```php
//KISS
$user=new getjump\Vk\Wrapper\User(getjump\Vk\Core::getInstance()->apiVersion('5.5'));
$user->get(1, 'photo_max_orig, sex'); //It will contain RequestTransaction, and will wait for your action, like getting response ->response or calling ->each(callback)
//Since __get and __call are overrided, we will request for a data, only when it neeeded
```
 
WE CAN USE MY OWN SAKHALIN TECHNOLOGIES AND TAKE ALL THE STUFF THAT VK HAVE FOR THAT REQUEST USING GENERATORS
```php
//FRIENDS GET
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

BUT YOU STILL CAN DO OLD STYLE STUFF
```php
 //SECOND OPTION TO JUST GET EVERYTHING, WITHOUT count BEING SEND
$friends->get(15157875, 'first_name, last_name')->response->each(function($i, $d) {
     if($d->online)
     {
         print $d->getName() . '<br>';
     }
});
```
 
THAT SNIPPET WILL SHOW YOU YOUR LAST 200 MESSAGES
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
