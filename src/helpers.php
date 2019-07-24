<?php

if (! function_exists('module_path')) {
    function module_path($name)
    {
        $module = app('modules')->find($name);

        return $module->getPath();
    }
}

if (! function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}

if (! function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param  string  $path
     * @return string
     */
    function public_path($path = '')
    {
        return app()->make('path.public') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $path);
    }
}

if ( ! function_exists( 'flog' ) ) {
    function _var_dump( $var ) {
        ob_start();
        print_r( $var );
        $v = ob_get_contents();
        ob_end_clean();

        return $v;
    }

    function flog( $var ) {
        file_put_contents( storage_path('logs') . '/log-' . date( 'Y-m-d' ) . '.txt', '+---+ ' . date( 'H:i:s d-m-Y' ) . ' +-----+' . PHP_EOL . _var_dump( $var ) . PHP_EOL . PHP_EOL, FILE_APPEND );
    }
}

