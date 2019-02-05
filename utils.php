<?php

//debugging functions
if(!function_exists('debug')) {

    function debug($obj, $suppress = false)
    {

        echo '<pre><font size=2>';
        var_dump($obj);
        echo '</font></pre>';

        if(!$suppress) {
            $trace = debug_backtrace();
            echo "<font size=2>" . $trace[0]['file'];
            echo ':' . $trace[0]['line'] . '</font>';
        }

    }
}

if(!function_exists('diebug')) {

    function diebug($obj, $suppress = false)
    {

        echo '<pre><font size=2>';
        var_dump($obj);
        echo '</font></pre>';

        if(!$suppress) {
            $trace = debug_backtrace();
            echo "<font size=2>" . $trace[0]['file'];
            echo ': ' . $trace[0]['line'] . '</font>';
        }

        die();
    }
}



function removeDirectory($path) {
	if(!strpos($path, APP_ROOT)>-1 && strlen($path) > strlen(APP_ROOT)){
		return false;
	}
 	$files = glob($path . '/*');
	foreach ($files as $file) {
		is_dir($file) ? removeDirectory($file) : unlink($file);
	}
	rmdir($path);
 	return;
}



function sanitize_title( $title ) {
	$title = preg_replace( '/[^a-z0-9]+/', '-', strtolower( $title ) );
	return $title;
}