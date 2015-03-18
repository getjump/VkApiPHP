<?php

namespace getjump\Vk\Wrapper;

use getjump\Vk\Model\Photos\UploadResponse;
use getjump\Vk\Model\Photos\UploadUrl;
use GuzzleHttp\Post\PostBody;
use GuzzleHttp\Post\PostFile;

class Photos extends BaseWrapper
{

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
     * @return UploadUrl
     */
    public function getMessagesUploadServer()
    {
        return $this->vk
            ->request('photos.getMessagesUploadServer')
            ->one();
    }

    /**
     * todo Process response
     * @param UploadResponse $data structure of response of uploading-photos-request
     */
    public function save($data)
    {
        $this->vk
            ->param('album_id', $data->aid)
            ->param('server', $data->server)
            ->param('photos_list', $data->photos_list)
            ->param('hash', $data->hash);

        if (!empty($data->gid)) {
            $this->vk->param('group_id', $data->gid);
        }

        $this->vk->request('photos.save')->execute();
    }

    public function saveMessagesPhoto($data)
    {
        return $this->vk
            ->param('photo', $data->photo)
            ->param('hash', $data->hash)
            ->param('server', $data->server)
            ->request('photos.saveMessagesPhoto')->one();
    }

    /**
     * Uploading photos in album
     *
     * @param array $listOfFilePaths array with file paths, which you want to upload to an album
     * @param bool|int|string $album_id ID of album. Album for uploading files
     * @param bool|int|string $group_id ID of group. Group which belongs album (optional)
     */
    public function uploadAlbum(array $listOfFilePaths = [], $album_id = false, $group_id = false)
    {
        if (sizeof($listOfFilePaths) > 5 || sizeof($listOfFilePaths) == 0) {
            // todo Exception
        }

        $server = $this->getUploadServer($album_id, $group_id);

        $request = $this->guzzle->createRequest('POST', $server->upload_url);
        /** @var PostBody $postBody */
        $postBody = $request->getBody();
        $fileIndex = 1;
        foreach ($listOfFilePaths as $filePath) {
            $postBody->addFile(new PostFile('file' . $fileIndex, fopen($filePath, 'r')));
            $fileIndex++;
        }
        $response = $this->guzzle->send($request);
        $this->save($response->json(['object' => 1]));
    }

    public function uploadMessages($file)
    {
        $server = $this->getMessagesUploadServer();
        $request = $this->guzzle->createRequest('POST', $server->upload_url);
        $postBody = $request->getBody();
        $postBody->addFile(new PostFile('photo', fopen($file, 'r')));
        $response = $this->guzzle->send($request);
        return $this->saveMessagesPhoto($response->json(['object' => 1]));
    }
}
