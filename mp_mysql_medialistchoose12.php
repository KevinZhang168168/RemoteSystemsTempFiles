<?php

//Kevin Zhang 开发环境测试成功，未连接小程序。
//PHP+MySQL测试结果：每种类型的测试结果在下面；

//小视频用户重新做筛选后，按照上传的时间降序排列，这个从数据库里提取。每次最多显示12个。
//有点麻烦，需要筛选很多条件
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$idStu = $_GET['idStu'];//获取从小程序传递过来的id值，表示学生的id；
    //$idSubject = $_GET['idSubject'];//获取从小程序传递过来的id值，表示筛选的主题id；
    $idStu = 1;
    $idSubject = 1;
    
    if ($idStu == null & $idSubject != null){
        
        //idStu为空，idSubject不为空，则执行这个，表示用户选择了一个主题；
        
        $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI FROM Student_shortVideo_log where Student_shortVideo_log_belongtoPoetryID_FK=". $idSubject . "". " order by Student_shortVideo_log_uploadtime DESC limit 0,12";
    
        /*测试结果
         * *SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI FROM Student_shortVideo_log where Student_shortVideo_log_belongtoPoetryID_FK=1 order by Student_shortVideo_log_uploadtime DESC limit 0,12[ { "idmedia_listchoose12": 1, "mediaid": "1", "SPcount": "2", "medianame": "王小虎的第一个视频", "Lcount": "4", "PicURI": "/image/media/lou.png", "Stuname": "王小虎", "StuPic": null }, { "idmedia_listchoose12": 2, "mediaid": "3", "SPcount": "1", "medianame": "米夏全的第一个视频", "Lcount": "2", "PicURI": "/image/media/lou.png", "Stuname": "米夏全", "StuPic": null }, { "idmedia_listchoose12": 3, "mediaid": "5", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 4, "mediaid": "6", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 5, "mediaid": "7", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 6, "mediaid": "8", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 7, "mediaid": "9", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null } ]
         */
        /*
         * [ { "idmedia_listchoose12": 1, "mediaid": "1", "SPcount": "2", "medianame": "王小虎的第一个视频", "Lcount": "4", "PicURI": "/image/media/lou.png", "Stuname": "王小虎", "StuPic": null }, { "idmedia_listchoose12": 2, "mediaid": "3", "SPcount": "1", "medianame": "米夏全的第一个视频", "Lcount": "2", "PicURI": "/image/media/lou.png", "Stuname": "米夏全", "StuPic": null }, { "idmedia_listchoose12": 3, "mediaid": "5", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 4, "mediaid": "6", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 5, "mediaid": "7", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 6, "mediaid": "8", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 7, "mediaid": "9", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null } ]
         */
        
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
        
        /*
        //有了班级的id值，我再找属于这个班级的所有学生的id；
        $sql2="select idStudent from Student where Student_belongto_classid_FK=".$row1."";
        mysqli_query($link, "set names 'utf8'");
        $result2 = mysqli_query($link, $sql2);//得到这个班级的id下所有学生的id值，是多个值；
        
        //有了所有学生的id值后，再把所有同一个班学生的小视频都找出来；
        if (mysqli_num_rows($result2) > 0) {
            while($row2 = $mysqli_fetch_assoc($result2)) {
                $sql3 = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from Student_shortVideo_log where idStudent=". $row2[idStudent] .""." order by Student_shortVideo_log_uploadtime DESC limit 0,12";
            }
        }
        */       
        /*
         * SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from mp_wx_zxj_demo_mysql.Student_shortVideo_log where Student_shortVideo_log_Stuid_FK in (select idStudent from mp_wx_zxj_demo_mysql.Student where Student_belongto_classid_FK=1) order by Student_shortVideo_log_uploadtime DESC limit 0,12;
         */
        /*
         * [ { "idmedia_listchoose12": 1, "mediaid": "1", "SPcount": "2", "medianame": "王小虎的第一个视频", "Lcount": "4", "PicURI": "/image/media/lou.png", "Stuname": "王小虎", "StuPic": null }, { "idmedia_listchoose12": 2, "mediaid": "2", "SPcount": "1", "medianame": "王小虎的第二个音频", "Lcount": "2", "PicURI": "/image/media/lou.png", "Stuname": "王小虎", "StuPic": null }, { "idmedia_listchoose12": 3, "mediaid": "5", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 4, "mediaid": "6", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 5, "mediaid": "7", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 6, "mediaid": "8", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 7, "mediaid": "9", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 8, "mediaid": "10", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null } ]
         */
        
        $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from Student_shortVideo_log where Student_shortVideo_log_Stuid_FK in (select idStudent from Student where Student_belongto_classid_FK=". $classid ."".") order by Student_shortVideo_log_uploadtime DESC limit 0,12";
        //echo($sql);
    }else if($idStu != null & $idSubject != null){
        /*
        //idStu不为空，idSubject不为空，则执行这个，表示用户选择了一个班级，同班，同时选择了一个主题；
        //idStu不为空，idSubject为空，则执行这个，表示用户选择了一个班级，同班；
        //首先，我只有学生的id值，要先查出他所在的班级，然后查出这个班级中有多少同学，然后把这个班级中所有同学的小视频都查找出来；
        $sql1 = "select Student_belongto_classid_FK from Student where idStudent=".$idStu."";
        mysqli_query($link, "set names 'utf8'");
        $result1 = mysqli_query($link, $sql1);
        $row1 = $mysqli_fetch_assoc($result1);//得到这个班级的id；
        
        //有了班级的id值，我再找属于这个班级的所有学生的id；
        $sql2="select idStudent from Student where Student_belongto_classid_FK=".$row1."";
        mysqli_query($link, "set names 'utf8'");
        $result2 = mysqli_query($link, $sql2);//得到这个班级的id下所有学生的id值，是多个值；
        
        //有了所有学生的id值后，再把所有同一个班学生的小视频都找出来；
        if (mysqli_num_rows($result2) > 0) {
            while($row2 = $mysqli_fetch_assoc($result2)) {
                $sql3 = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from Student_shortVideo_log where idStudent=". $row2[idStudent] ."" order by Student_shortVideo_log_uploadtime DESC limit 0,12";
            }
        }       
        */
        //idStu不为空，idSubject为空，则执行这个，表示用户选择了一个班级，同班；
        //首先，我只有学生的id值，要先查出他所在的班级，然后查出这个班级中有多少同学，然后把这个班级中所有同学的小视频都查找出来；
        $sql1 = "select Student_belongto_classid_FK from Student where idStudent=".$idStu."";
        mysqli_query($link, "set names 'utf8'");
        $result1 = mysqli_query($link, $sql1);
        //$row1 = $mysqli_fetch_assoc($result1);
        while($row1 = mysqli_fetch_assoc($result1)) {
            $classid=$row1["Student_belongto_classid_FK"];//得到这个班级的id；
        }
        
        /*
         * SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from mp_wx_zxj_demo_mysql.Student_shortVideo_log where Student_shortVideo_log_belongtoPoetryID_FK=1 and Student_shortVideo_log_Stuid_FK in (select idStudent from mp_wx_zxj_demo_mysql.Student where Student_belongto_classid_FK=1) order by Student_shortVideo_log_uploadtime DESC limit 0,12;
         */
        /*
         * [ { "idmedia_listchoose12": 1, "mediaid": "1", "SPcount": "2", "medianame": "王小虎的第一个视频", "Lcount": "4", "PicURI": "/image/media/lou.png", "Stuname": "王小虎", "StuPic": null }, { "idmedia_listchoose12": 2, "mediaid": "5", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 3, "mediaid": "6", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 4, "mediaid": "7", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 5, "mediaid": "8", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null }, { "idmedia_listchoose12": 6, "mediaid": "9", "SPcount": "0", "medianame": "张三的视频", "Lcount": "0", "PicURI": null, "Stuname": "张三", "StuPic": null } ]
         */
        
        $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from Student_shortVideo_log where Student_shortVideo_log_belongtoPoetryID_FK=".$idSubject." and Student_shortVideo_log_Stuid_FK in (select idStudent from Student where Student_belongto_classid_FK=". $classid ."".") order by Student_shortVideo_log_uploadtime DESC limit 0,12";
        //echo($sql);
    }
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class media_below9{
        public $idmedia_listchoose12;//这个media的数据库中的id；没有意义，可以不传。
        public $mediaid;//这是media的id值；
        public $SPcount;//Share Page的数量；
        public $medianame;//视频的名字；
        public $Lcount;//Like的数量；
        public $PicURI;//这个视频的图片；
        public $Stuname;//作者的名字；
        public $StuPic;//作者的图片；
    }
    $idmedia_listchoose12=1;
    
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
            $media_below9->idmedia_listchoose12=$idmedia_listchoose12++;//对的
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
