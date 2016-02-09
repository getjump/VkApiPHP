<?php

namespace getjump\Vk\Model\Photos;

use getjump\Vk\Model\BaseModel;

/**
 * Structure of response data obtained from POST request to 'upload_url', which was obtained by querying the API method photos.getUploadServer
 *
 * @link https://vk.com/dev/photos.getUploadServer documentation
 */
class UploadResponse extends BaseModel
{
    /** @var string */
    public $server;
    /** @var string utility information which designed to send back in next API call */
    public $photos_list;
    /** @var string ID of album in which photos have been uploaded */
    public $aid;
    /** @var string hash */
    public $hash;
    /** @var string ID of group that owns album (appears only if you want to upload photos in group's album) */
    public $gid;
}
