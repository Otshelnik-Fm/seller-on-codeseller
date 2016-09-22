<?php

// создаем папку при активации
$soc_dir_path = RCL_UPLOAD_PATH.'seller-xml/';
if(!wp_mkdir_p($soc_dir_path)){
    wp_mkdir_p($soc_dir_path);
}