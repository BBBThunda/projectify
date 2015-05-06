<?php

/**
 * Provides a standard object for passing results/data to the Response object
 *
 * PHP version 5
 *
 * @author Bobby Cahill
 * @license GPLv3: /LICENSE.txt
 * @link    https://github.com/BBBThunda/projectify
 */

class Result { 

    public $success = false;

    public $message = '';

    public $data;

    /**
     * @param  bool     $is_success whether request was successful
     * @param  string   $msg        message to send back to client
     * @param  stdClass $dataObj    object containing data for the client
     *
     * @access public
     * @since  5/6/2015
     */
    public function __construct($is_success, $msg, $dataObj) {

        $success = $is_success;
        $message = $msg;
        $data = $dataObj;

    }

}
