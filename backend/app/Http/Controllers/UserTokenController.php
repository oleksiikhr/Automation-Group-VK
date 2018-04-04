<?php

namespace App\Http\Controllers;

use App\Http\web\vk\methods\Account;
use App\Http\web\vk\methods\Users;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\UserToken;

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
        return response()->json(UserToken::all());
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
        return response()->json(UserToken::findOrFail($id));
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
            'token' => 'required|string',
        ]);

        $response = (new Users($request->token))
            ->get(null, ['domain', 'photo_100'])
            ->response[0];

        $user = User::firstOrCreate(
            ['id' => $response->id],
            ['first_name' => $response->first_name, 'last_name' => $response->last_name,
                'photo_100' => $response->photo_100, 'domain' => $response->domain]
        );

        $bitMask = (new Account($request->token))->getAppPermissions()->response;

        $userToken = new UserToken;
        $userToken->user_id = $user->id;
        $userToken->token = $request->token;
        $userToken->mask = $bitMask;
        $userToken->last_used = Carbon::now();
        $userToken->save();

        return response()->json(['message' => 'Токен добавлен']);
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
        return response()->json(UserToken::destroy($id));
    }
}
