<?php

namespace App\Http\Controllers\web\vk\methods;

use App\Http\Controllers\web\vk\Vk;

class Groups extends Vk
{
    /**
     * Returns information about communities by their IDs.
     *
     * @param string $groupId - ID or screen name of the community
     * @param array  $groupIds - IDs or screen names of communities
     * @param array|null $fields - Group fields to return.
     *
     * @return mixed
     *
     * @see https://vk.com/dev/fields_groups
     */
    public function getById(?string $groupId = null, ?array $groupIds = null, ?array $fields = null): mixed
    {
        $response = self::request('groups.getById', [
            'group_id'  => $groupId,
            'group_ids' => $groupIds,
            'fields'    => $fields
        ], $this->_token);

        return json_decode($response);
    }
}
