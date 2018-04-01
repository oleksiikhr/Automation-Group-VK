<?php

namespace App\Http\Controllers;

use App\Http\web\vk\methods\Account;
use App\Http\web\vk\methods\Users;
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

        $appPermissions = (new Account($request->token))->getAppPermissions();

        // TODO Has error => abort

        $user = (new Users($request->token))->get();

        // TODO Check user in DB
        // TODO Add token to DB

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
