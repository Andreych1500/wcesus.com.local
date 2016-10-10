<?php
// Очищення тимчасових файлів
if($_SERVER['REMOTE_ADDR'] == '192.186.205.227'){
    function removeDirectory($dir){
        if(!file_exists($dir)){
            return false;
        }

        if($objs = glob($dir."/*")){
            foreach($objs as $obj){
                is_dir($obj)? removeDirectory($obj) : unlink($obj);
            }
        }

        if(is_dir($dir)){
            rmdir($dir);
        }
    }

    removeDirectory($_SERVER['DOCUMENT_ROOT'].'/uploaded/temporarily/');
    removeDirectory($_SERVER['DOCUMENT_ROOT'].'/uploaded/db_tables/');
}