<?php

namespace App\Http\web\vk\methods;

use App\Http\web\vk\Vk;

class Groups extends Vk
{
    /**
     * Returns information about communities by their IDs.
     *
     * @param array|null  $groupIds - IDs or screen names of communities
     * @param array|null  $fields - Group fields to return.
     *
     * @see https://vk.com/dev/fields_groups - Group object
     * @see https://vk.com/dev/groups.getById - Method
     *
     * @return object
     */
    public function getById(array $groupIds, ?array $fields = null): object
    {
        return self::request('groups.getById', [
            'group_ids' => $groupIds ? implode(',', $groupIds) : null,
            'fields'    => $fields ? implode(',', $fields) : null,
        ]);
    }
}
