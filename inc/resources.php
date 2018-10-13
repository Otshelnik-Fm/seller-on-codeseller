<?php

if (!defined('ABSPATH')) exit;

// great packer's
// http://dean.edwards.name/packer/
// https://cssminifier.com/

// скрипты и стили для шаблонов и фильтра
function soc_filter_script(){
    rcl_enqueue_script('soc_filter_script', rcl_addon_url('res/soc-filter-script.min.js', __FILE__), false, true);
}

function soc_filter_css(){
    rcl_enqueue_style('soc_filter_style', rcl_addon_url('res/soc-filter-style.min.css', __FILE__));
}

function soc_card_css(){
    rcl_enqueue_style('soc_card', rcl_addon_url('res/soc-template-card.min.css', __FILE__));
}

function soc_list_css(){
    rcl_enqueue_style('soc_list', rcl_addon_url('res/soc-template-list.min.css', __FILE__));
}

function soc_full_width_css(){
    rcl_enqueue_style('soc_fullwidth', rcl_addon_url('res/soc-template-full-width.min.css', __FILE__));
}
