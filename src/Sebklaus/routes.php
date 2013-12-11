<?php

// Use 'before' filter to make sure all configured application routes are executed
// Register new wildcard route and check if it contains '_profiler'
\App::before(function()
{
    if (\Config::get('profiler::urlToggle')) {
        // Register GET route
        \Route::get('{path?}', function($path)
        {
            if (stristr($path, '_profiler') !== false) {
                // Origin
                $origin = str_ireplace('_profiler', '', $path);
                // Check, if production is current environment and Profiler not specifically enabled
                if (\App::environment() == 'production' && \Session::get('_profiler') !== true) {
                    // Data to send to view
                    $data = array(
                        'assetPath' =>  __DIR__.'/../../public/',
                        'path' =>       $path,
                        'origin' =>     $origin,
                    );
                    // Show Password view
                    return \View::make('profiler::profiler.password', $data);
                // Resume normal Profiler enabling/ disabling
                } else {
                    // Check if a '_profiler' session key exists and reverse its value
                    $state = \Session::get('_profiler') ? false : true;
                    // Apply new state to profiler config
                    \Session::set('_profiler', $state);
                    // Redirect back to origin
                    return \Redirect::to($origin);
                }
            }
        })->where('path', '.+');
        // Register POST route (only in production environment)
        if (\App::environment() == 'production') {
            \Route::post('{path?}', function($path)
            {
                if (stristr($path, '_profiler') !== false) {
                    // Origin
                    $origin = str_ireplace('_profiler', '', $path);
                    // Check if a '_profiler' session key exists and reverse its value
                    $state = \Session::get('_profiler') ? false : true;
                    // Check, if submitted password matches set 'urlTogglePassword' password
                    if (\Hash::check(\Input::get('password'), \Config::get('profiler::urlTogglePassword'))) {
                        // Apply new state to profiler config, if password checks out
                        \Session::set('_profiler', $state);
                    }
                    // Redirect back to origin
                    return \Redirect::to($origin);
                }
            })->where('path', '.+');
        }
    }
});