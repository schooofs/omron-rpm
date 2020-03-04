<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

if (!function_exists('ci_site_url')) {
    function ci_site_url($uri = '')
    {
        $CI =& get_instance();
        return $CI->config->site_url($uri);
    }
}

if (!function_exists('ci_base_url')) {
    function ci_base_url($uri = '')
    {
        $CI =& get_instance();
        return $CI->config->base_url($uri);
    }
}
