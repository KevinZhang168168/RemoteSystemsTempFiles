<?php

//Kevin Zhang 开发环境测试成功，未连接小程序
//把诗歌的扩展阅读朗读提取出来。
//PHP+MySQL测试结果：[ { "Poetryexid": "1", "PoetryexAuURI1": "/image/voice/lou.png", "PoetryexAuURI2": "/image/voice/lou.png", "PoetryexAuURI3": "/image/voice/lou.png" }, { "Poetryexid": "2", "PoetryexAuURI1": "/image/voice/lou.png", "PoetryexAuURI2": "/image/voice/lou.png", "PoetryexAuURI3": "/image/voice/lou.png" }, { "Poetryexid": "3", "PoetryexAuURI1": "/image/voice/lou.png", "PoetryexAuURI2": "/image/voice/lou.png", "PoetryexAuURI3": "/image/voice/lou.png" }, { "Poetryexid": "4", "PoetryexAuURI1": "/image/voice/lou.png", "PoetryexAuURI2": "/image/voice/lou.png", "PoetryexAuURI3": "/image/voice/lou.png" } ] 

//$name=$_GET["name"];//接收参数
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//提取一个诗歌的视频内容
if($link){
    //$Poetryexid = $_GET['Poetryexid'];//获取从小程序传递过来的id值，
    
    //idPoetry=1暂时按照1代替，实际微信小程序用idPoetry
    $Poetryexid=1;
    $sql = "SELECT idPoetry_extended_reading,Poetry_extended_readingAudioURI1,Poetry_extended_readingAudioURI2,Poetry_extended_readingAudioURI3 FROM Poetry_extended_reading where Poetry_extended_readingPoetryid_FK=".$Poetryexid."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class poetryexreading{
        public $Poetryexid;
        public $PoetryexAuURI1;
        public $PoetryexAuURI2;
        public $PoetryexAuURI3;
       
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $poetryexreading=new poetryexreading();
            $poetryexreading->Poetryexid=$row["idPoetry_extended_reading"];
            $poetryexreading->PoetryexAuURI1=$row["Poetry_extended_readingAudioURI1"];
            $poetryexreading->PoetryexAuURI2=$row["Poetry_extended_readingAudioURI2"];
            $poetryexreading->PoetryexAuURI3=$row["Poetry_extended_readingAudioURI3"];
          
            
            $data[] = $poetryexreading;
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