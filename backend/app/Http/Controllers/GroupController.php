<?php

namespace App\Http\Controllers;

use App\Http\web\vk\exceptions\VkApiException;
use App\Http\web\vk\methods\Groups;
use Illuminate\Http\Request;
use App\UserToken;
use App\Group;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO Temporary
        return response()->json(Group::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // TODO Temporary
        return response()->json(Group::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id'            => 'required|integer|min:1',
            'user_token_id' => 'required|integer|min:1'
        ]);

        $userToken = UserToken::findOrFail($request->user_token_id);

        try {
            $response = (new Groups($userToken->token))
                ->getById([$request->id], [
                    'description', 'members_count'
                ])
                ->response[0];
        } catch (VkApiException $e) {
            return response()->json($e->getMessage(), 422);
        }

        $group = new Group((array) $response);
        $group->save();

        return response()->json($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // TODO Temporary
        return response()->json(Group::destroy($id));
    }
}
