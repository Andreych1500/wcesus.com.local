<?php
class UploaderFiles {
    static $error = '';
    static $tmp = array('image/jpeg', 'image/gif', 'image/png');
    static $tup = array('jpg', 'gif', 'jpeg', 'png');
    static $info = array();

    static function getType($file, $checkType){
        if($file['size'] < 0 || $file['size'] > 52428800){
            return array('error' => 'File Size does not suit us');
        } elseif(isset($file['error']) && $file['error'] > 0) {
            return array('error' => 'Error Could not load file!');
        } elseif(!in_array($file['type'], self::$tmp) && $checkType == 'file') {
            return array('type' => 'file');
        } elseif(in_array($file['type'], self::$tmp) && $checkType == 'img') {
            return array('type' => 'image');
        } else {
            return array('error' => 'Error Could not load file!');
        }
    }

    static function file($file){
        $uploadFile = $_SERVER['DOCUMENT_ROOT'].'/uploaded/temporarily/';
        preg_match("#\*|\||\\|\/|\:|\"|\<|\>|\?#uis", $file['name'], $matches);
        preg_match("#\.\w+$#uis", $file['name'], $type);

        if(count($type) <= 0){
            return array('error' => 'Invalid file type!');
        }

        $name = 'file'.date('YmdHis').rand(10000, 99999).$type[0];

        if(count($matches) > 0){
            return array('error' => 'Invalid characters in the file name!');
        } elseif(copy($file['tmp_name'], $uploadFile.$name)) {
            return array('file' => '/uploaded/temporarily/'.mb_strtolower($name));
        } else {
            return array('error' => 'An error occurred while copying resources!');
        }
    }

    static function photo($file){
        if($file['size'] < 500 || $file['size'] > 52428800){
            return array('error' => 'File Size does not suit us');
        } else {
            preg_match('#\.([a-z]+)$#ui', $file['name'], $matches);
            if(isset($matches[1])){
                $matches[1] = mb_strtolower($matches[1]);
                $temp = getimagesize($file['tmp_name']);

                if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/uploaded/temporarily/')){
                    mkdir($_SERVER['DOCUMENT_ROOT'].'/uploaded/temporarily'); //створення деректорії для тимчасових файлів
                }

                if(in_array($file['type'], self::$tmp)){
                    $nameFile = date('HisYmd').'i'.'ph'.time().'m'.rand(100, 999).'g'.'.'.str_replace('image/', '', $file['type']);
                } else {
                    return array('error' => 'No exist type image');
                }

                self::$info['src'] = '/uploaded/temporarily/'.$nameFile;
                self::$info['name'] = $nameFile;
                self::$info['width'] = $temp[0];
                self::$info['height'] = $temp[1];

                if(!in_array($matches[1], self::$tup)){
                    return array('error' => 'No exist type image');
                    self::$error = 'Unsuitable extension image';
                } elseif(!in_array($temp['mime'], self::$tmp)) {
                    self::$error = 'Not suitable file type, you can only download images';
                } elseif($temp[1] < 30 || $temp[0] < 40) {
                    self::$error = 'Not suitable size image';
                } elseif($temp[1] > $temp[0] * 5) {
                    self::$error = 'Not suitable size image';
                } elseif($temp[1] >= 10000 || $temp[0] >= 10000) {
                    self::$error = 'Expansion in pixels too large';
                } elseif(!move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].self::$info['src'])) {
                    self::$error = 'The image is not loaded! Error';
                } else {
                    return array('image' => self::$info);
                }
            } else {
                return array('error' => 'No file exist!');
            }

            if(!empty(self::$error)){
                return array('error' => self::$error);
            }
        }
    }

    static function resizeImage($file, $width, $height){

        if($width > 1100 || $height > 1100){
            return array('error' => 'The dimensions of the new image is too big!');
        }

        $name = $_SERVER['DOCUMENT_ROOT'].'/uploaded/temporarily/'.$file;
        $temp = getimagesize($_SERVER['DOCUMENT_ROOT'].'/uploaded/temporarily/'.$file); // дістаєм дійсну ширину і висоту зображення

        $new_width = $width;
        $new_height = $height;

        $thumb = imagecreatetruecolor($new_width, $new_height); //створюєм каркас зображення з шириною і висотою

        switch($temp[2]){
            case 1:
                $src_image = imagecreatefromgif($name);

                $colorTransparent = imagecolortransparent($src_image);
                if($colorTransparent >= 0 && $colorTransparent < imagecolorstotal($src_image)){
                    imagepalettecopy($thumb, $src_image);
                    imagefill($thumb, 0, 0, $colorTransparent);
                    imagecolortransparent($thumb, $colorTransparent);
                    imagetruecolortopalette($thumb, true, 256);
                }
                break;
            case 2:
                $src_image = imagecreatefromjpeg($name);
                break;
            case 3:
                $src_image = imagecreatefrompng($name);

                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);

                $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
                imagefilledrectangle($thumb, 0, 0, 140, 140, $transparent);

                break;
        }

        imagecopyresampled($thumb, $src_image, 0, 0, 0, 0, $new_width, $new_height, $temp[0], $temp[1]);

        switch($temp[2]){
            case 1:
                imagegif($thumb, $name, 100);
                break;
            case 2:
                imagejpeg($thumb, $name, 100);
                break;
            case 3:
                imagepng($thumb, $name, 0);
                break;
        }

        imagedestroy($thumb);

        return array('resize' => $file);
    }
}