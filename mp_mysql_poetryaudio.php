<?php

//Kevin Zhang 开发环境测试成功，未连接小程序
//把诗歌的三个朗读提取出来；
//PHP+MySQL测试结果：[ { "Poetryaudio1URI": "/image/media/lou.png", "Poetryaudio2URI": "/image/media/lou.png", "Poetryaudio3URI": "/image/media/lou.png" } ] 

//$name=$_GET["name"];//接收参数
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//提取一个诗歌的视频内容
if($link){
    //idPoetry = $_GET['idPoetry'];//获取从小程序传递过来的id值，
    
    //idPoetry=1暂时按照1代替，实际微信小程序用idPoetry
    $idPoetry=1;
    $sql = "SELECT Poetryaudio1URI,Poetryaudio2URI,Poetryaudio3URI FROM Poetry where idPoetry=".$idPoetry."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class poetryaudio{
        public $Poetryaudio1URI;
        public $Poetryaudio2URI;
        public $Poetryaudio3URI;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $poetryaudio=new poetryaudio();
            $poetryaudio->Poetryaudio1URI=$row["Poetryaudio1URI"];
            $poetryaudio->Poetryaudio2URI=$row["Poetryaudio2URI"];
            $poetryaudio->Poetryaudio3URI=$row["Poetryaudio3URI"];
           
            $data[] = $poetryaudio;
            //echo($coursein);
        }
        
        //echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//将请求结果转换为json格式
        //echo json_encode($data);
        //echo sizeof($data);
    }
    
}
else{
    echo "db connect failed!";
}

?> 