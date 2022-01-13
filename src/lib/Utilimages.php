<?php


namespace User\Instagram\lib;

class Utilimages{
    public static function storeImage(array $photo):string{
        $target_dir = "./public/img/photos/";
        $extarr = explode('.',$photo["name"]);
        $filename = $extarr[sizeof($extarr)-2];
        $ext = $extarr[sizeof($extarr)-1];
        $hash = md5(Date('Ymdgi') . $filename) . '.' . $ext;
        $target_file = $target_dir . $hash;
        $uploadOk = 1;
        $check = getimagesize($photo["tmp_name"]);

        if ($check !== false){
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        if ($uploadOk == 0){
            return "";
        } else {
            if (move_uploaded_file($photo["tmp_name"], $target_file)){
                return $hash;
            } else {
                return "";
            }
        }
    }
}