<?php

namespace gvk\vk;

use gvk\Web;

class VK extends Web
{
    const VK_API = 'https://api.vk.com/method/';
    const VK_VER = '5.63';

    /**
     * Send request to VK.
     *
     * @param string $method
     * @param array  $params
     * @param string $token
     * @param string $typeMethod
     *
     * @return object
     */
    public static function send($method, $params, $token, $typeMethod = 'GET')
    {
        $params['v'] = self::VK_VER;
        $params['access_token'] = $token;

        if ($typeMethod !== 'POST') {
            $data = self::request( self::VK_API . $method . '?' . http_build_query($params), true );
        } else {
            $data = self::request( self::VK_API . $method, true, 'POST', http_build_query($params) );
        }

        return $data;
    }

    /**
     * Create a new post.
     *
     * @param string $message
     * @param string $attachments
     * @param string $typeMethod
     *
     * @return object
     */
    public static function createPost($message, $attachments = null, $typeMethod = 'GET')
    {
        return self::send('wall.post', [
            'owner_id'    => '-' . G_ID,
            'from_group'  => 1,
            'message'     => $message,
            'attachments' => $attachments,
            'guid'        => rand()
        ], T_USR, $typeMethod);
    }

    /**
     * Send message to User.
     *
     * @param string $message
     * @param int    $user_id
     * @param string $typeMethod
     *
     * @return object
     */
    public function sendMessage($message, $user_id, $typeMethod = 'GET')
    {
        return $this->send('messages.send', [
            'user_id'   => $user_id,
            'random_id' => rand(),
            'message'   => $message
        ], T_MSG, $typeMethod);
    }

    /**
     * Delete comment in post.
     *
     * @param int $comment_id
     *
     * @return object
     */
    public function deleteComment($comment_id)
    {
        return $this->send('wall.deleteComment', [
            'owner_id'   => '-' . G_ID,
            'comment_id' => $comment_id
        ], T_USR);
    }

    /**
     * Send comment to post.
     *
     * @param string $message
     * @param int    $post_id
     *
     * @return object
     */
    public function sendComment($message, $post_id)
    {
        return $this->send('wall.createComment', [
            'owner_id'   => '-' . G_ID,
            'message'    => $message,
            'post_id'    => $post_id,
            'guid'       => rand(),
            'from_group' => 1
        ], T_USR);
    }
}
