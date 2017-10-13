<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('css_url'))
{
    function css_url($file)
    {
        return base_url().'public/build/css/'.$file.'.css';
    }
}

if ( ! function_exists('js_url'))
{
    function js_url($file)
    {
        return base_url().'public/build/js/'.$file.'.js';
    }
}


if ( ! function_exists('img_url'))
{
    function img_url($file)
    {
        return base_url().'public/build/images/'.$file;
    }
}

if ( ! function_exists('img_project'))
{
    function img_project($project_id, $file)
    {
        return base_url().'public/projects_pictures/p-'.$project_id.'/'.$file;
    }
}

if ( ! function_exists('img_project_thumb'))
{
    function img_project_thumb($project_id, $file)
    {
        return base_url().'public/projects_pictures/p-'.$project_id.'/thumb_'.$file;
    }
}


if ( ! function_exists('img'))
{
    function img($file, $alt = '')
    {
        return '<img src="'.img_url($file).'"alt="'.$alt.'" />';
    }

}

function friendly_url($value){
    $url = strtolower(preg_replace('/\W+/', '-', $value));
    $url = rtrim($url,'-');
    return $url;
}