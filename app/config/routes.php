<?php

use pew\router\Route;

return [
    # load a snippet
    Route::from("/load/{name}")->to("AppController@load"),

    Route::group()->methods("post")->routes([
        # save a snippet
        Route::from("/save")->to("AppController@save"),
        # delete a snippet
        Route::from("/delete")->to("AppController@delete"),
        # run script
        Route::from("/run")->to("AppController@run"),
        # install composer package
        Route::from("/install")->to("AppController@install"),
        # remove composer package
        Route::from("/uninstall")->to("AppController@uninstall"),
    ]),
    
    # homepage
    "/" => "AppController@index",
];
