<?php declare(strict_types=1);

namespace src\controllers\photos;

use src\controllers\FileController;
use core\vk\methods\Photos;
use core\vk\methods\Wall;
use core\vk\Attachment;
use core\Token;
use core\Web;

abstract class PhotosController extends FileController implements PhotosInterface
{
    /**
     * @var string
     */
    protected $hashtags = ['photos'];

    /**
     * @var string
     */
    protected $folder;

    /**
     * @var int - MAX 10
     */
    private $_count = 1;

    public function __construct(int $count = 1)
    {
        parent::__construct($this->folder);
        $this->addHashtag("photos_{$this->folder}");
        $this->_count = $count > 10 ? 10 : $count;
    }

    /**
     * Main method.
     *
     * @return void
     */
    public function start()
    {
        $files = $this->getFilesRecursive($this->pathEntry);

        if (count($files) < 1) {
            die('PhotosController - files are empty');
        }

        $chosenIndexes = $this->chooseFiles($files);
        $attachments = '';

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

        try {
            Wall::post(Token::getToken(), $this->getHashtag(), $attachments);
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

    /**
     * Choose file(s) to upload on servers VK.
     *
     * @param  array $files
     * @return array indexes
     */
    private function chooseFiles(array $files): array
    {
        if ($this->_count > 1) {
            if (count($files) < $this->_count) {
                return array_keys($files);
            }
            return array_rand($files, $this->_count);
        }

        return [array_rand($files, $this->_count)];
    }
}
