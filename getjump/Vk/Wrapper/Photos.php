<?php

namespace getjump\Vk\Wrapper;

use getjump\Vk\Model\Photos\UploadResponse;
use getjump\Vk\Model\Photos\UploadUrl;
use GuzzleHttp\Post\PostFile;

class Photos extends BaseWrapper {

    /**
     * @param $album
     * @param bool $group
     * @return UploadUrl
     */
    public function getUploadServer($album, $group = false)
    {
        return $this->vk
                ->param('album_id', $album)
                ->param('group_id', $group)
                ->request('photos.getUploadServer')
                ->one();
    }

    /**
     * todo Process response
     * @param UploadResponse $data
     */
    public function save($data)
    {
        $this->vk
            ->param('album_id', $data->aid)
            ->param('server', $data->server)
            ->param('photos_list', $data->photos_list)
            ->param('hash', $data->hash)
            ->request('photos.save')->execute();
    }

    public function uploadAlbum(array $files = array(), $album, $group = false)
    {
        if(sizeof($files) > 5 || sizeof($files) == 0)
        {
            // todo Exception
        }

        $server = $this->getUploadServer($album, $group);

        $request = $this->guzzle->createRequest('POST', $server->upload_url);
        $postBody = $request->getBody();
        foreach($files as $k => $file)
        {
            $postBody->addFile(new PostFile('file'.($k+1), fopen($file, 'r')));
        }
        $response = $this->guzzle->send($request);
        $this->save($response->json(['object' => 1]));
    }
} 