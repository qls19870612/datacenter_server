<?php

class ImageCode
{
	var $English = 'monofont.ttf';
	var $Chinese = 'STXIHEI.TTF';
    var $imageType = 'png';	
    //构造函数
    function ImageCode()
    {
		
		$MyPath=dirname(__FILE__);
        $this->Chinese = $MyPath.'/Fonts/'.$this->Chinese;
        $this->English = $MyPath.'/Fonts/'.$this->English;
    }
    
    //生成验证码字符串
    function generateCode($length,$type=1)
    {
		switch ($type){
            case 0:
                $possible = '0123456789';
                break;
            case 1:
                $possible = 'ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz';
                break;
           case 2:
                $possible = array('零','一','二','三','四','五','六','七','八','九','十','诚','信');
                break;
            default:
                $possible = '12346789ABCDEFGHJKLMNPQRTUVWXYabcdefghjkmnpqrtuvwxy';
         }
		$code = '';
			$i = 0;
			while ($i < $length) { 
				if ($type==2)
				{
					$code .= $possible[mt_rand(0, count($possible)-1)];
				}else{
					$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
				}
				$i++;
			}		
		return $code;
	}
	
	function image($code,$font,$bgcolor='#ffffff',$color='#000000',$ncolor='#eeeeee',$font_size='30',$width='120',$height='40')
	{
		$image = @imagecreate($width, $height) or die('初始化GD库失败');
		list($r, $g, $b) = $this->hex2rgb($bgcolor);
		$background_color = imagecolorallocate($image, $r, $g, $b);
		list($r, $g, $b) = $this->hex2rgb($color);
		$text_color = imagecolorallocate($image, $r, $g, $b);
		list($r, $g, $b) = $this->hex2rgb($ncolor);
		$noise_color = imagecolorallocate($image, $r, $g, $b);
		
		/* generate random dots in background */
		for( $i=0; $i<($width*$height)/3; $i++ ) {
			imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
		}
		/* generate random lines in background */
		for( $i=0; $i<($width*$height)/150; $i++ ) {
			imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
		}
		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $font, $code) or die('imagettfbbox函数执行错误');
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		imagettftext($image, $font_size, 0, $x, $y, $text_color, $font , $code) or die('imagettfbbox函数执行错误');
		
		// 输出图像
        switch (strtolower($this->imageType)) {
        case 'png':
            header("Content-type: " . image_type_to_mime_type(IMAGETYPE_PNG));
            imagepng($image);
            break;
        case 'gif':
            header("Content-type: " . image_type_to_mime_type(IMAGETYPE_GIF));
            imagegif($image);
            break;
        case 'jpg':
        default:
            header("Content-type: " . image_type_to_mime_type(IMAGETYPE_JPEG));
            imagejpeg($image);
        }
        imagedestroy($image);
        unset($img);
		
	}
	

	//把颜色代码转成RBG
    function hex2rgb($color, $defualt = 'ffffff')
    {
        $color = strtolower($color);
        if (substr($color, 0, 2) == '0x') {
            $color = substr($color, 2);
        } elseif (substr($color, 0, 1) == '#') {
            $color = substr($color, 1);
        }
        $l = strlen($color);
        if ($l == 3) {
            $r = hexdec(substr($color, 0, 1));
            $g = hexdec(substr($color, 1, 1));
            $b = hexdec(substr($color, 2, 1));
            return array($r, $g, $b);
        } elseif ($l != 6) {
            $color = $defualt;
        }

        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));
        return array($r, $g, $b);
    }
}
