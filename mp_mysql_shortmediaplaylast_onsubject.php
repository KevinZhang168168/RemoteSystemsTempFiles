<?php

//Kevin Zhang 开发环境测试成功，未连接小程序。这个还没有完成。
//PHP+MySQL测试结果：[ { "idmedia_last": null, "mediaid": "2", "SPcount": "1", "medianame": "王小虎的第二个音频", "Lcount": "2", "PicURI": "/image/media/lou.png", "Stuname": "王小虎", "StuPic": null, "idmedia_below9": 1 } ]

//小视频播放页面，页面上的值还是要从数据库中直接提取，不能从上一个页面上带入，原因有两点：第一，那个数据肯定不是最新的数据；
//第二，小视频主页上只显示了9个小视频，如果用户想查看第十个，则必须重新向数据库查询数据，因为主页上没有这个数据。
//所以用户进入这个页面还是只传递mediaid值，其余数据从数据中查找；
//现在的问题是，主页上9个视频的显示是按照时间的降序排列，如何找到小视频的上一个和下一个视频呢？
//只能这样测试一下，看看行不行，在mp_mysql_shortmediaplaynext.php中实现
//idStudent_shortVideo_log这个值是自增加一的，时间约晚的，这个值越大，我是按照时间降序排列的，因此，下一个我就按照
//idStudent_shortVideo_log这个值+1；直到max为止，到头了。

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$idMedia = $_GET['idMedia'];//获取从小程序传递过来的id值，表示小视频的id值；
    //$idStu = $_GET['idStu'];//获取从小程序传递过来的id值，表示小视频的id值；
    //$idSubject = $_GET['idSubject'];//获取从小程序传递过来的id值，表示小视频的id值；
    $idMedia = 4;
    $idStu = 1;
    $idSubject = 1;
    
    $sqlmax="SELECT max(idStudent_shortVideo_log) FROM Student_shortVideo_log";
    mysqli_query($link, "set names 'utf8'");
    $resultmax = mysqli_query($link, $sqlmax);
    //echo()
    if (mysqli_fetch_assoc($resultmax)> $idMedia)
    {
        //$idMedia = $idMedia + 1;//如果传进来的id值小于数据库里的最大值，则加一；
        //解决办法参考另外一个php
        //idStudent_shortVideo_log = (select min(idStudent_shortVideo_log) from Student_shortVideo_log where idStudent_shortVideo_log > ".$idMedia.")";
        if ($idStu == null & $idSubject != null){
            
            //idStu为空，idSubject不为空，则执行这个，表示用户选择了一个主题；
            $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI FROM Student_shortVideo_log where Student_shortVideo_log_belongtoPoetryID_FK=". $idSubject . "". " and idStudent_shortVideo_log = (select min(idStudent_shortVideo_log) from Student_shortVideo_log where idStudent_shortVideo_log > ".$idMedia.")";
            
        }else if($idStu != null & $idSubject == null){
            
            //idStu不为空，idSubject为空，则执行这个，表示用户选择了一个班级，同班；
            //首先，我只有学生的id值，要先查出他所在的班级，然后查出这个班级中有多少同学，然后把这个班级中所有同学的小视频都查找出来；
            $sql1 = "select Student_belongto_classid_FK from Student where idStudent=".$idStu."";
            mysqli_query($link, "set names 'utf8'");
            $result1 = mysqli_query($link, $sql1);
            //$row1 = $mysqli_fetch_assoc($result1);
            while($row1 = mysqli_fetch_assoc($result1)) {
                $classid=$row1["Student_belongto_classid_FK"];//得到这个班级的id；
            }
            
            $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from Student_shortVideo_log where Student_shortVideo_log_Stuid_FK in (select idStudent from Student where Student_belongto_classid_FK=". $classid ."".") and idStudent_shortVideo_log = (select min(idStudent_shortVideo_log) from Student_shortVideo_log where idStudent_shortVideo_log > ".$idMedia.")";
            
        }else if($idStu != null & $idSubject != null){
            
            //idStu不为空，idSubject为空，则执行这个，表示用户选择了一个班级，同班；
            //首先，我只有学生的id值，要先查出他所在的班级，然后查出这个班级中有多少同学，然后把这个班级中所有同学的小视频都查找出来；
            $sql1 = "select Student_belongto_classid_FK from Student where idStudent=".$idStu."";
            mysqli_query($link, "set names 'utf8'");
            $result1 = mysqli_query($link, $sql1);
            //$row1 = $mysqli_fetch_assoc($result1);
            while($row1 = mysqli_fetch_assoc($result1)) {
                $classid=$row1["Student_belongto_classid_FK"];//得到这个班级的id；
            }
            
            $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from Student_shortVideo_log where Student_shortVideo_log_belongtoPoetryID_FK=".$idSubject." and Student_shortVideo_log_Stuid_FK in (select idStudent from Student where Student_belongto_classid_FK=". $classid ."".")  and idStudent_shortVideo_log = (select min(idStudent_shortVideo_log) from Student_shortVideo_log where idStudent_shortVideo_log > ".$idMedia.")";
            
        }
    }
    else{
        return(0);//表示没有数据了，返回0；
        exit;
    }
    
    
    //$sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI FROM Student_shortVideo_log where idStudent_shortVideo_log=".$idMedia."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class media_below9{
        public $idmedia_last;//这个media的数据库中的id；没有意义，可以不传。
        public $mediaid;//这是media的id值；
        public $SPcount;//Share Page的数量；
        public $medianame;//视频的名字；
        public $Lcount;//Like的数量；
        public $PicURI;//这个视频的图片；
        public $Stuname;//作者的名字；
        public $StuPic;//作者的图片；
    }
    $idmedia_last=1;
    
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
            $media_below9->idmedia_below9=$idmedia_last++;//对的
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
