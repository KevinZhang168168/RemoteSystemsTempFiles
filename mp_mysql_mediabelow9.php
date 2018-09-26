<?php

//Kevin Zhang 开发环境测试成功，未连接小程序。
//PHP+MySQL测试结果：[ { "idmedia_below9": 1, "mediaid": "1", "SPcount": "2", "medianame": "王小虎的第一个视频", "Lcount": "4", "PicURI": "/image/media/lou.png", "Stuname": "王小虎", "StuPic": null }, { "idmedia_below9": 2, "mediaid": "2", "SPcount": "1", "medianame": "王小虎的第二个音频", "Lcount": "2", "PicURI": "/image/media/lou.png", "Stuname": "王小虎", "StuPic": null }, { "idmedia_below9": 3, "mediaid": "3", "SPcount": "1", "medianame": "米夏全的第一个视频", "Lcount": "2", "PicURI": "/image/media/lou.png", "Stuname": "米夏全", "StuPic": null }, { "idmedia_below9": 4, "mediaid": "4", "SPcount": "1", "medianame": "米夏全的第二个音频", "Lcount": "1", "PicURI": "/image/media/lou.png", "Stuname": "米夏全", "StuPic": null } ]

//小视频首页下方出现9小视频，按照上传的时间降序排列，这个从数据库里提取。每次最多显示9个。
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI FROM mp_wx_zxj_demo_mysql.Student_shortVideo_log order by Student_shortVideo_log_uploadtime DESC limit 0,9";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class media_below9{
        public $idmedia_below9;//这个media的数据库中的id；没有意义，可以不传。
        public $mediaid;//这是media的id值；
        public $SPcount;//Share Page的数量；
        public $medianame;//视频的名字；
        public $Lcount;//Like的数量；
        public $PicURI;//这个视频的图片；
        public $Stuname;//作者的名字；
        public $StuPic;//作者的图片；
    }
    $idmedia_below9=1;
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            //这个视频被分享的数量
            $sql_SPcount = "SELECT count(*) FROM mp_wx_zxj_demo_mysql.student_log_SP where Student_log_SPid_FK="  .$row["idStudent_shortVideo_log"]."" ;//重写
            mysqli_query($link, "set names 'utf8'");
            $result_SPcount = mysqli_query($link, $sql_SPcount);
            
            //这个视频被点赞的数量
            $sql_Lcount = "SELECT count(*) FROM mp_wx_zxj_demo_mysql.student_log_L where Student_log_Lid_FK="  .$row["idStudent_shortVideo_log"]."" ;//重写
            mysqli_query($link, "set names 'utf8'");
            $result_Lcount = mysqli_query($link, $sql_Lcount);
            
            //这个视频作者的名字和头像
            $sql_name_pic = "select StudentName,Student_wxPic from student where idStudent="  .$row["Student_shortVideo_log_Stuid_FK"]."";//重写
            mysqli_query($link, "set names 'utf8'");
            $result_name_pic = mysqli_query($link, $sql_name_pic);
            
            $media_below9=new media_below9();
            $media_below9->idmedia_below9=$idmedia_below9++;//对的
            $media_below9->mediaid=$row["idStudent_shortVideo_log"];//对的
            
            while($row2 = mysqli_fetch_assoc($result_Lcount)) {
                $media_below9->Lcount=$row2["count(*)"];//这个视频被点赞的数量
            }
            
            
            $media_below9->medianame=$row["Student_shortVideo_logName"];//对的
            
            while($row1 = mysqli_fetch_assoc($result_SPcount)) {
                $media_below9->SPcount=$row1["count(*)"];//这个视频被分享的数量
            }
            
            
            $media_below9->PicURI=$row["Student_shortVideo_logPICURI"];//对的
            
            while($row3 = mysqli_fetch_assoc($result_name_pic)) {
                $media_below9->Stuname=$row3["StudentName"];
                $media_below9->StuPic=$row3["Student_wxPic"];
            }
            
            
            $data[] = $media_below9;
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
