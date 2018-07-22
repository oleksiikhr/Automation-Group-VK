<?php declare(strict_types=1);

namespace src\controllers\photos;

use src\controllers\FileController;
use core\vk\enums\Attachment;
use core\vk\methods\Photos;
use core\vk\methods\Wall;
use core\Token;
use core\Web;

abstract class PhotosController extends FileController implements PhotosInterface
{
    /**
     * @var string
     */
    protected $folder;

    public function __construct()
    {
        parent::__construct($this->folder);
    }

    /**
     * Main method.
     *
     * @return void
     */
    public function start()
    {
        $files = $this->getFilesRecursive($this->pathEntry);
        $chosenIndexes = $this->chooseFiles($files);
        $attachments = '';

        if (count($files) < 1) {
            die('PhotosController - files are empty');
        }

        foreach ($chosenIndexes as $index) {
            $uri = realpath($this->pathExit . '/' . $files[$index]);
            try {
                $server = Photos::getWallUploadServer(Token::getToken());
                $upload = self::uploadPhoto($server->response->upload_url, $uri);
                $res = Photos::saveWallPhotoGroup(Token::getToken(), $upload->photo, $upload->server, $upload->hash);
                $attachments .= Attachment::generate([Attachment::PHOTO => $res->response[0]->id], $res->response[0]->owner_id) . ',';
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        }

        // TODO Message
        // TODO Hashtags

        try {
            Wall::post(Token::getToken(), 'Test', $attachments);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Upload image to server.
     *
     * @param  string  $uploadUrl
     * @param  string  $file - URI
     * @return object
     * @throws \Exception
     */
    public static function uploadPhoto($uploadUrl, $file): object
    {
        $res = Web::uploadFiles($uploadUrl, [
            'photo' => curl_file_create($file)
        ]);

        return json_decode($res);
    }
}
