<?php

namespace App\Http\Controllers;

use App\Cron;
use Illuminate\Http\Request;

class CronController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListOfCron(Request $request)
    {
        return response()->json(Cron::all());
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOneCron($id)
    {
        return response()->json(Cron::findOrFail($id));
    }

    /**
     * @param string $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editOneCron($id, Request $request)
    {
        // TODO
        return response()->json();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCron(Request $request)
    {
        // TODO
        return response()->json();
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOneCron($id)
    {
        // TODO
        return response()->json(Cron::destroy($id));
    }
}
