<?php

Route::group(['middleware' => 'cors'], function () {

    Route::group(['prefix' => 'cron'], function () {
        Route::get('/', 'CronController@getListOfCron');
        Route::get('{id}', 'CronController@getOneCron');
        Route::put('{id}', 'PollController@editOneCron');
        Route::post('/', 'PollController@createCron');
        Route::delete('{id}', 'PollController@deleteOneCron');
    });

    Route::group(['prefix' => 'groups'], function () {
        Route::get('/', 'GroupController@getList');
        Route::get('{id}', 'GroupController@getOne');
        Route::put('{id}', 'GroupController@editOne');
        Route::post('/', 'GroupController@create');
        Route::delete('{id}', 'GroupController@deleteOne');
    });

    Route::group(['prefix' => 'polls'], function () {
        Route::get('/', 'PollController@getListOfPolls');
        Route::get('{id}', 'PollController@getOnePoll');
        Route::put('{id}', 'PollController@editOnePoll');
        Route::post('/', 'PollController@createPoll');
        Route::delete('{id}', 'PollController@deleteOnePoll');

        Route::group(['prefix' => 'types'], function () {
            Route::get('/', 'PollController@getListOfPollTypes');
            Route::get('{id}', 'PollController@getOnePollType');
            Route::put('{id}', 'PollController@editOnePollType');
            Route::post('/', 'PollController@createPollType');
            Route::delete('{id}', 'PollController@deleteOnePollType');
        });
    });

});
