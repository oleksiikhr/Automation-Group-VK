<?php

namespace gvk\vk;

use gvk\Web;

class VK extends Web
{
    /**
     * Send request form vk.
     *
     * @param string $method
     * @param array $params
     * @param string $token
     * @param string $typeMethod
     *
     * @return object
     */
    public function send($method, $params, $token, $typeMethod = 'GET')
    {
        $params['v'] = VERSION_VK;
        $params['access_token'] = $token;

        if ($typeMethod !== 'POST') {
            $data = $this->request( METHOD_VK . $method . '?' . http_build_query($params), true );
        } else {
            $data = $this->request( METHOD_VK . $method, true, 'POST', http_build_query($params) );
        }

        if ( ! empty($data->error) && $data->error->error_code == 6 ) {
            sleep(3);
            return $this->send($method, $params, $token, $typeMethod);
        }

        return $data;
    }

    /**
     * Create new post.
     *
     * @param string $message
     * @param string $attachments
     * @param string $typeMethod
     *
     * @return object
     */
    public function createPost($message, $attachments = null, $typeMethod = 'GET')
    {
        return $this->send('wall.post', [
            'owner_id'    => '-' . GROUP_ID,
            'from_group'  => 1,
            'message'     => $message,
            'attachments' => $attachments,
            'guid'        => rand()
        ], TOKEN_USER, $typeMethod);
    }

    /**
     * Send message for User.
     *
     * @param string $message
     * @param int $user_id
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
        ], TOKEN_GROUP_MSG, $typeMethod);
    }

    /**
     * Delete comment for post.
     *
     * @param int $comment_id
     *
     * @return object
     */
    public function deleteComment($comment_id)
    {
        return $this->send('wall.deleteComment', [
            'owner_id'   => '-' . GROUP_ID,
            'comment_id' => $comment_id
        ], TOKEN_USER);
    }

    /**
     * Post comment for post.
     *
     * @param string $message
     * @param int $post_id
     *
     * @return object
     */
    public function sendComment($message, $post_id)
    {
        return $this->send('wall.createComment', [
            'owner_id'   => '-' . GROUP_ID,
            'message'    => $message,
            'post_id'    => $post_id,
            'guid'       => rand(),
            'from_group' => 1
        ], TOKEN_USER);
    }
}
