<?php

namespace App\Http\web\vk\methods;

use App\Http\web\vk\Vk;

class Groups extends Vk
{
    /**
     * Returns information about communities by their IDs.
     *
     * @param array $groupIds - IDs or screen names of communities
     * @param array|null $fields - Group fields to return.
     *
     * @return object
     *
     * @throws \App\Http\web\vk\exceptions\VkApiException
     *
     * @see https://vk.com/dev/objects/group - Group object
     * @see https://vk.com/dev/groups.getById - Method
     */
    public function getById(array $groupIds, ?array $fields = null): object
    {
        return self::request('groups.getById', [
            'group_ids' => $groupIds ? implode(',', $groupIds) : null,
            'fields'    => $fields ? implode(',', $fields) : null,
        ]);
    }
}
