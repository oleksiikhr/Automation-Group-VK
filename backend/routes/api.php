<?php

Route::apiResource('cron', 'CronController');

Route::apiResource('groups', 'GroupController');

Route::apiResource('users/tokens', 'UserTokenController');

//    Route::group(['prefix' => 'polls'], function () {
//        Route::get('/', 'PollController@getListOfPolls');
//        Route::get('{id}', 'PollController@getOnePoll');
//        Route::put('{id}', 'PollController@editOnePoll');
//        Route::post('/', 'PollController@createPoll');
//        Route::delete('{id}', 'PollController@deleteOnePoll');
//
//        Route::group(['prefix' => 'types'], function () {
//            Route::get('/', 'PollController@getListOfPollTypes');
//            Route::get('{id}', 'PollController@getOnePollType');
//            Route::put('{id}', 'PollController@editOnePollType');
//            Route::post('/', 'PollController@createPollType');
//            Route::delete('{id}', 'PollController@deleteOnePollType');
//        });
//    });
