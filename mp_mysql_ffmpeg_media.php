<?php
//做音频合成的时候找到的一个php操作ffmpeg 的类库。GitHub地址：https://github.com/PHP-FFMpeg/PHP-FFMpeg/。本文的例子大部分都是上面的
//在使用之前请安装好 FFMpeg 。如何安装？请看 FFmpeg 安装教程。
//使用composer快速安装 > composer require php-ffmpeg/php-ffmpeg。
//注意：请在 php.ini 中开启这两个函数proc_open,proc_get_status。找到 disable_functions 将里面的这两个函数去掉就行了

//我在程序中有两个地方需要这个功能；
//第一是后台上传了视频或者音频后，有个截图，视频的第一帧就可以，音频则用缺省的图片；
//第二是用户上传了自己的小视频或者音频后，有个截图，视频是第一帧就可以，音频则用缺省的图片；

//这个功能不在windows上做了，上了linux后再做

include 'lib\src\FFMpeg\FFMpeg.php';
//include 'lib\src\FFMpeg\FFMpegServiceProvider.php';
include 'lib\src\FFMpeg\FFProbe.php';


$path = [
    
    'ffmpeg.binaries' => 'lib\src\ffmpeg',
    
    'ffprobe.binaries' => 'lib\src\ffprobe',
];
/*
$ffmpeg = FFMpeg\FFMpeg::create($path);
$a1 = '/mnt/hgfs/www/test/a1.mp3';
$v1 = '/mnt/hgfs/www/test/v1.mp4';
$v2 = '/mnt/hgfs/www/test/v2.mp4';
$v3 = '/mnt/hgfs/www/test/v3.mp4';
*/
$v1080 = 'file\demo2_video2.mp4';

$ffmpeg = FFMpeg\FFMpeg::create($path);
$video = $ffmpeg->open($v1080);
$frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(2));//提取第几秒的图像
$frame->save('image.jpg');


/*
function get_video_orientation($video_path) {
    $cmd = "/usr/local/ffmpeg/bin/ffprobe " . $video_path . " -show_streams 2>/dev/null";
    $result = shell_exec($cmd);
    
    $orientation = 0;
    if(strpos($result, 'TAG:rotate') !== FALSE) {
        $result = explode("\n", $result);
        foreach($result as $line) {
            if(strpos($line, 'TAG:rotate') !== FALSE) {
                $stream_info = explode("=", $line);
                $orientation = $stream_info[1];
            }
        }
    }
    return $orientation;
}

$movie = new ffmpeg_movie($video_filePath);
$frame = $movie->getFrame(1);
$gd = $frame->toGDImage();
if ($orientation = $this->get_video_orientation($video_filePath)) {
    $gd = imagerotate($gd, 360-$orientation, 0);
}
$img="./test.jpg";
imagejpeg($gd, $img);
imagedestroy($gd_image);
*/

?>