<?php

namespace App\Http\Controllers;

use App\Http\web\vk\exceptions\VkApiException;
use App\Http\web\vk\methods\Account;
use App\Http\web\vk\methods\Users;
use Illuminate\Http\Request;
use App\Http\web\vk\Vk;
use Carbon\Carbon;
use App\UserToken;
use App\User;

class UserTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO Temporary
        return response()->json(UserToken::with('user')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userToken = UserToken::with('user')->findOrFail($id);

        return response()->json($userToken);
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
        $this->validate($request, [
            'name'        => 'nullable|string|max:' . self::MAX_LEN_STRING_DB,
            'description' => 'nullable|string|max:600',
        ]);

        $userToken = UserToken::findOrFail($id);
        $userToken->name = $request->exists('name') ? $request->name : $userToken->name;
        $userToken->description = $request->exists('description') ? $request->description : $userToken->description;
        $userToken->save();

        return response()->json($userToken);
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
            'name'        => 'required|string|max:' . self::MAX_LEN_STRING_DB,
            'description' => 'nullable|string|max:600',
            'token'       => 'required|string',
        ]);

        try {
            // Get the current user from VK.
            $vkUser = (new Users($request->token))->get(null, ['domain', 'photo_100'])->response[0];
            $bitMask = (new Account($request->token))->getAppPermissions()->response;

        } catch (VkApiException $e) {
            return response()->json($e->getMessage(), 422);
        }

        $user = User::firstOrCreate([
            'id' => $vkUser->id
        ], [
            'first_name' => $vkUser->first_name,
            'last_name'  => $vkUser->last_name,
            'photo'      => Vk::filterDefaultImages($vkUser->photo_100),
            'domain'     => $vkUser->domain
        ]);

        $userToken = new UserToken;
        $userToken->name = $request->name;
        $userToken->user_id = $user->id;
        $userToken->token = $request->token;
        $userToken->description = $request->description;
        $userToken->mask = $bitMask;
        $userToken->last_used = Carbon::now();
        $userToken->save();

        return response()->json($userToken);
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
        $destroyed = UserToken::destroy($id);

        return response()->json($destroyed);
    }
}
