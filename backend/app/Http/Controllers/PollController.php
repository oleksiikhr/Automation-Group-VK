<?php

namespace App\Http\Controllers;

use App\Poll;
use App\PollType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PollController extends Controller
{
    /*
     * |----------------------------------------------------------------------
     * | Polls
     * |----------------------------------------------------------------------
     * |
     */

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListOfPolls(Request $request)
    {
        // TODO
        return response()->json(Poll::all());
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOnePoll($id)
    {
        // TODO
        return response()->json(Poll::findOrFail($id));
    }

    /**
     * @param string $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editOnePoll($id, Request $request)
    {
        // TODO
        $poll = Poll::findOrFail($id);
        $poll->quest = $request->quest;
        $poll->user_id = $request->user_id;
        $poll->type_id = $request->type_id;
        $poll->save();
        return response()->json($poll);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPoll(Request $request)
    {
        // TODO
        return response()->json(Poll::insert([
            'quest' => $request->quest,
            'user_id' => $request->user_id,
            'type_id' => $request->type_id,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]));
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOnePoll($id)
    {
        // TODO
        return response()->json(Poll::destroy($id));
    }

    /*
     * |----------------------------------------------------------------------
     * | Poll Types
     * |----------------------------------------------------------------------
     * |
     */

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListOfPollTypes(Request $request)
    {
        // TODO
        return response()->json(PollType::all());
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOnePollType($id)
    {
        // TODO
        return response()->json(PollType::findOrFail($id));
    }

    /**
     * @param string $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editOnePollType($id, Request $request)
    {
        // TODO
        $pollType = PollType::findOrFail($id);
        $pollType->name = $request->name;
        $pollType->quest_is_answer = $request->quest_is_answer;
        $pollType->min_count_answers = $request->min_count_answers;
        $pollType->use_count_answers = $request->use_count_answers;
        $pollType->max_count_answers = $request->max_count_answers;
        $pollType->pattern_answer = $request->pattern_answer;
        $pollType->pattern_correct_answer = $request->pattern_correct_answer;
        $pollType->save();
        return response()->json($pollType);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPollType(Request $request)
    {
        // TODO
        return response()->json(PollType::insert([
            'name' => $request->name,
            'quest_is_answer' => $request->quest_is_answer,
            'min_count_answers' => $request->min_count_answers,
            'use_count_answers' => $request->use_count_answers,
            'max_count_answers' => $request->max_count_answers,
            'pattern_answer' => $request->pattern_answer,
            'pattern_correct_answer' => $request->pattern_correct_answer,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]));
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOnePollType($id)
    {
        // TODO
        return response()->json(PollType::destroy($id));
    }
}
