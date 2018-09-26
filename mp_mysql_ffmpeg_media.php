<?php
//����Ƶ�ϳɵ�ʱ���ҵ���һ��php����ffmpeg ����⡣GitHub��ַ��https://github.com/PHP-FFMpeg/PHP-FFMpeg/�����ĵ����Ӵ󲿷ֶ��������
//��ʹ��֮ǰ�밲װ�� FFMpeg ����ΰ�װ���뿴 FFmpeg ��װ�̡̳�
//ʹ��composer���ٰ�װ > composer require php-ffmpeg/php-ffmpeg��
//ע�⣺���� php.ini �п�������������proc_open,proc_get_status���ҵ� disable_functions �����������������ȥ��������

//���ڳ������������ط���Ҫ������ܣ�
//��һ�Ǻ�̨�ϴ�����Ƶ������Ƶ���и���ͼ����Ƶ�ĵ�һ֡�Ϳ��ԣ���Ƶ����ȱʡ��ͼƬ��
//�ڶ����û��ϴ����Լ���С��Ƶ������Ƶ���и���ͼ����Ƶ�ǵ�һ֡�Ϳ��ԣ���Ƶ����ȱʡ��ͼƬ��

//������ܲ���windows�����ˣ�����linux������

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
$frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(2));//��ȡ�ڼ����ͼ��
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