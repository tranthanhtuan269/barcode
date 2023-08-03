<?php
     $multiple_thumb = [];
     
    if (isset($_FILES['files']['tmp_name'][0])) {
        $fn = $_FILES['files']['tmp_name'][0];
        $size = getimagesize($fn);
        $ratio = $size[0]/$size[1]; // width/height
        
        if( $ratio > 1) {
            $width_1 = 470;
            $height_1 = round(470/$ratio);
        
            $width_2 = 360;
            $height_2 = round(360/$ratio);
        
            $width_3 = 270;
            $height_3 = round(270/$ratio);
        } else {
            $width_1 = 470*$ratio;
            $height_1 = 470;
        
            $width_3 = 360*$ratio;
            $height_3 = 360;
        
            $width_3 = 270*$ratio;
            $height_3 = 270;
        }
        
        $multiple_thumb = [
            ['width'=>$width_1, 'height'=>$height_1, 'name'=>'image_size_470'],
            ['width'=>$width_2, 'height'=>$height_2, 'name'=>'image_size_360'],
            ['width'=>$width_3, 'height'=>$height_3, 'name'=>'image_size_240'],
        ];
    }