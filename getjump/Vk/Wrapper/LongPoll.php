<?php
namespace getjump\Vk\Wrapper;

use getjump\Vk\Wrapper\User;

/**
 * Class LongPoll
 * Implements LongPolling part of API.
 * @package getjump\Vk\Wrapper
 */
class LongPoll extends BaseWrapper
{
    const URL_CONNECTION_INFO = 'http://%s?act=a_check&key=%s&ts=%s&wait=25&mode=2';
    CONST LONG_POOL_REQUEST_METHOD = 'messages.getLongPollServer';

    public $userCache = [];
    public $userMap = [];

    /**
     * @var \GuzzleHttp\Client
     */
    public $guzzle = false;

    /**
     * @param $d
     * @return string
     */
    public function getConnectionInfo($d)
    {
        return sprintf(self::URL_CONNECTION_INFO, $d->server, $d->key, $d->ts);
    }

    /**
     * @return array|bool
     */
    public function getServerData()
    {
        return $this->vk->request(self::LONG_POOL_REQUEST_METHOD)->response->getResponse();
    }

    public function doLoop()
    {
        if (!$this->guzzle) {
            $this->guzzle = new \GuzzleHttp\Client();
        }

        $server = $this->getServerData();
        $initial = $this->getConnectionInfo($server);

        $user = new User($this->vk);

        $userMap = [];
        $userCache = [];

        $fetchData = function ($id) use ($user, &$userMap, &$userCache) {
            if (!isset($userMap[$id])) {
                $userMap[$id] = sizeof($userCache);
                $userCache[] = $user->get($id)->response->get();
            }

            return $userCache[$userMap[$id]];
        };

        while ($data = $this->guzzle->get($initial)->json(['object' => true])) {
            $server->ts = $data->ts;
            $initial = $this->getConnectionInfo($server);

            foreach ($data->updates as $update) {
                switch ($update[0]) {
                    case 4:
                        $data = $fetchData($update[3]);
                        if ($update[2] & 2)
                            continue;
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
                        $data = $fetchData($update[1] * -1);
                        $status = $update[2] == 1 ? "AFK" : "Exit";
                        printf("User %s offline(%s)\n", $data->first_name . ' ' . $data->last_name, $status);
                        break;
                    case 8:
                        $data = $fetchData($update[1] * -1);
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