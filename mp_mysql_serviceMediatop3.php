<?php
//这里要写一个Service，每天只在固定的时间内读取数据后写入media_top3;这个程序需要加入Linux crontab中，还未加入。
//每天凌晨2点，把数据库点赞量最多的三个小视频放入数据库中media_top3；
//Linux crontab定时执行任务
//例如：00 02 * * * /usr/bin/php -f /home/wwwroot/default/test/serviceMediatop3.php
//当然，为了用户的更好使用体验，可以将这个操作每天执行多次；

//例如从数据库中读取的数值为：[ { "idmedia_top3service": 1, "mediaid": "2", "SPcount": "1", "medianame": "王小虎的第二个音频", "Lcount": "5", "PicURI": "/image/media/lou.png", "Stuname": "王小虎", "StuPic": null }, { "idmedia_top3service": 2, "mediaid": "1", "SPcount": "2", "medianame": "王小虎的第一个视频", "Lcount": "4", "PicURI": "/image/media/lou.png", "Stuname": "王小虎", "StuPic": null }, { "idmedia_top3service": 3, "mediaid": "3", "SPcount": "1", "medianame": "米夏全的第一个视频", "Lcount": "2", "PicURI": "/image/media/lou.png", "Stuname": "米夏全", "StuPic": null } ]
//将media_top3的数据清空，然后把上面三个数据insert进去；
//插入的数据如下：
//INSERT INTO media_top3 SET media_top3mediaid_FK=2,media_top3SPcount=1,media_top3name='王小虎的第二个音频',media_top3PicURI='/image/media/lou.png',media_top3Lcount=5,media_top3Stuname='王小虎',media_top3StuPic=''
//INSERT INTO media_top3 SET media_top3mediaid_FK=1,media_top3SPcount=2,media_top3name='王小虎的第一个视频',media_top3PicURI='/image/media/lou.png',media_top3Lcount=4,media_top3Stuname='王小虎',media_top3StuPic=''
//INSERT INTO media_top3 SET media_top3mediaid_FK=3,media_top3SPcount=1,media_top3name='米夏全的第一个视频',media_top3PicURI='/image/media/lou.png',media_top3Lcount=2,media_top3Stuname='米夏全',media_top3StuPic=''

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //从Student_log_L中找到点赞数量最多的三个作品的id值和点赞数量
    $sql = "SELECT Student_log_Lid_FK,count(*) FROM Student_log_L group by Student_log_Lid_FK order by count(*) DESC limit 0,3";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class media_top3service{
        public $idmedia_top3service;//这个media的数据库中的id；没有意义，可以不传。
        public $mediaid;//这是media的id值；
        public $SPcount;//Share Page的数量；
        public $medianame;//视频的名字；
        public $Lcount;//Like的数量；
        public $PicURI;//这个视频的图片；
        public $Stuname;//作者的名字；
        public $StuPic;//作者的图片；
    }
    $idmedia_top3service=1;
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        //先把media_top3的数据删除；
        $sql_delete = "delete FROM media_top3";
        mysqli_query($link, "set names 'utf8'");
        $result_delete = mysqli_query($link, $sql_delete);
        
        while($row = mysqli_fetch_assoc($result)) {
            
            //这个视频被分享的数量
            $sql_SPcount = "SELECT count(*) FROM student_log_SP where Student_log_SPid_FK="  .$row["Student_log_Lid_FK"]."" ;
            mysqli_query($link, "set names 'utf8'");
            $result_SPcount = mysqli_query($link, $sql_SPcount);
            
            //这个视频的名字和图片
            $sql_Lcount = "SELECT Student_shortVideo_logName,Student_shortVideo_logPICURI FROM Student_shortVideo_log where idStudent_shortVideo_log="  .$row["Student_log_Lid_FK"]."" ;
            mysqli_query($link, "set names 'utf8'");
            $result_Lcount = mysqli_query($link, $sql_Lcount);
            
            //这个视频作者的名字和头像
            $sql_name_pic = "select StudentName,Student_wxPic from student where idStudent=(select Student_shortVideo_log_Stuid_FK from Student_shortVideo_log where idStudent_shortVideo_log="  .$row["Student_log_Lid_FK"].")";
            mysqli_query($link, "set names 'utf8'");
            $result_name_pic = mysqli_query($link, $sql_name_pic);
            
            $media_top3service=new media_top3service();
            $media_top3service->idmedia_top3service=$idmedia_top3service++;//对的
            $media_top3service->mediaid=$row["Student_log_Lid_FK"];//对的
            
            $media_top3service->Lcount=$row["count(*)"];//这个视频被点赞的数量
            
            while($row1 = mysqli_fetch_assoc($result_SPcount)) {
                $media_top3service->SPcount=$row1["count(*)"];//这个视频被分享的数量
            }
            
            while($row2 = mysqli_fetch_assoc($result_Lcount)) {
                $media_top3service->medianame=$row2["Student_shortVideo_logName"];//小视频的名字
                $media_top3service->PicURI=$row2["Student_shortVideo_logPICURI"];//小视频的图片
            }
            
            while($row3 = mysqli_fetch_assoc($result_name_pic)) {
                $media_top3service->Stuname=$row3["StudentName"];
                $media_top3service->StuPic=$row3["Student_wxPic"];
            }
            
            //把新计算的数值逐一插入进去；
            $sql_insert = "INSERT INTO media_top3 SET media_top3mediaid_FK=" .$row["Student_log_Lid_FK"]."" . ",media_top3SPcount=".$media_top3service->SPcount."" . ",media_top3name='".$media_top3service->medianame."'".",media_top3PicURI='".$media_top3service->PicURI."'".",media_top3Lcount=".$row["count(*)"]."".",media_top3Stuname='".$media_top3service->Stuname."'".",media_top3StuPic='".$media_top3service->StuPic."'";
            echo($sql_insert);
            mysqli_query($link, "set names 'utf8'");
            $result_insert = mysqli_query($link, $sql_insert);
            
            $data[] = $media_top3service;
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