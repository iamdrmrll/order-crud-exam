<?php

/**
 * ----------------------------------------------------------------
 * Check the segment of the URL/URI
 * ----------------------------------------------------------------
 */
if (!function_exists('checkSegment')) {
    function checkSegment($segment, $text, $return_data) {
        $request = app('request');
        if ($request->segment($segment) === $text || in_array($request->segment($segment), (array) $text)) {
            return $return_data;
        }
        return null; // Return null if no match is found
    }
}