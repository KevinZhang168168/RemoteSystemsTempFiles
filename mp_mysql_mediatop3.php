<?php

//Kevin Zhang 开发环境测试成功，未连接小程序。
//PHP+MySQL测试结果：[ { "idmedia_top3": "1", "mediaid": "1", "SPcount": "11", "medianame": "第一", "Lcount": "111", "PicURI": "/image/media/lou.png", "Stuname": "张三", "StuPic": "/image/media/lou.png" }, { "idmedia_top3": "2", "mediaid": "2", "SPcount": "22", "medianame": "第二", "Lcount": "222", "PicURI": "/image/media/lou.png", "Stuname": "李四", "StuPic": "/image/media/lou.png" }, { "idmedia_top3": "3", "mediaid": "3", "SPcount": "33", "medianame": "第三", "Lcount": "333", "PicURI": "/image/media/lou.png", "Stuname": "王五", "StuPic": "/image/media/lou.png" } ]

//小视频首页上出现3个点赞最多的小视频，这个从数据库里提取。
//在服务器端写一个service，每隔1个小时，统计点赞数量最大的三个小视频放到这里存储，这样数据库压力能减小。每次页面显示的top3在这里读取。这个数据库中存储的数据可以足够在小视频页面中使用了，不必再次读取其他table。
//同时，把这个视频的作者的名字和图片也显示出来。
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    $sql = "SELECT * FROM media_top3";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class media_top3{
        public $idmedia_top3;
        public $mediaid;//这是media的id值；
        public $SPcount;//Share Page的数量；
        public $medianame;
        public $Lcount;//Like的数量；
        public $PicURI;//这个视频的图片；
        public $Stuname;//作者的名字；
        public $StuPic;//作者的图片；
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $media_top3=new media_top3();
            $media_top3->idmedia_top3=$row["idmedia_top3"];
            $media_top3->mediaid=$row["media_top3mediaid_FK"];
            $media_top3->SPcount=$row["media_top3SPcount"];
            $media_top3->medianame=$row["media_top3name"];
            $media_top3->Lcount=$row["media_top3Lcount"];
            $media_top3->PicURI=$row["media_top3PicURI"];
            $media_top3->Stuname=$row["media_top3Stuname"];
            $media_top3->StuPic=$row["media_top3StuPic"];
            $data[] = $media_top3;
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
