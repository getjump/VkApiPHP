<?php
namespace getjump\Vk\Wrapper;


class LongPoll extends BaseWrapper {

    public $userCache = [];
    public $userMap = [];

    /**
     * @var \GuzzleHttp\Client
     */
    public $guzzle = false;

    public function getConnectionInfo($d)
    {
        return sprintf("http://%s?act=a_check&key=%s&ts=%s&wait=25&mode=2", $d->server, $d->key, $d->ts);
    }

    public function getServerData()
    {
        return $this->vk->request('messages.getLongPollServer')->response->getResponse();
    }

    public function doLoop()
    {
        if(!$this->guzzle)
        {
            $this->guzzle = new \GuzzleHttp\Client();
        }

        $server = $this->getServerData();
        $initial = $this->getConnectionInfo($server);

        $user = new \getjump\Vk\Wrapper\User($this->vk);

        $userMap = [];
        $userCache = [];

        $fetchData = function($id) use($user, &$userMap, &$userCache)
        {
            if(!isset($userMap[$id]))
            {
                $userMap[$id] = sizeof($userCache);
                $userCache[] = $user->get($id)->response->get();
            }

            return $userCache[$userMap[$id]];
        };

        while($data=$this->guzzle->get($initial)->json(['object' => true]))
        {
            $server->ts = $data->ts;
            $initial = $this->getConnectionInfo($server);

            foreach($data->updates as $update)
            {
                switch($update[0]) {
                    case 4:
                        $data = $fetchData($update[3]);
                        if($update[2] & 2) continue;
                        printf("New message from %s '%s'\n", $data->first_name . ' ' . $data->last_name, $update[6]);
                        var_dump($update);
                        break;
                    case 61:
                        $data = $fetchData($update[1]);
                        printf("User %s writing\n", $data->first_name . ' ' . $data->last_name);
                        break;
                    case 101:
                        break;
                    case 9:
                        $data = $fetchData($update[1]*-1);
                        $status = $update[2] == 1 ? "AFK" : "Exit";
                        printf("User %s offline(%s)\n", $data->first_name . ' ' . $data->last_name, $status);
                        break;
                    case 8:
                        $data = $fetchData($update[1]*-1);
                        printf("User %s online\n", $data->first_name . ' ' . $data->last_name);
                        break;
                    default:
                        printf("Unknown event %s {%s}\n", $update[0], implode(',', $update));
                        break;
                }
            }
        }
    }
}