<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request)
    {
        return response()->json(Group::all());
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOne($id)
    {
        return response()->json(Group::findOrFail($id));
    }

    /**
     * @param string $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editOne($id, Request $request)
    {
        // TODO Get only group_id. Fetch VK api. Fill DB.

        return response()->json();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|min:1'
        ]);

        // TODO Get only group_id. Fetch VK api. Fill DB.

        return response()->json();
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOne($id)
    {
        // TODO
        return response()->json(Group::destroy($id));
    }
}
