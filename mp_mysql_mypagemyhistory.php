<?php

//Kevin Zhang 开发环境测试成功，未连接小程序。
//PHP+MySQL测试结果：[ { "id": 1, "mediaid": "1", "SPcount": "2", "medianame": "王小虎的第一个视频", "Lcount": "4", "PicURI": "/image/media/lou.png", "Stuname": "王小虎", "StuPic": null }, { "id": 2, "mediaid": "2", "SPcount": "1", "medianame": "王小虎的第二个音频", "Lcount": "2", "PicURI": "/image/media/lou.png", "Stuname": "王小虎", "StuPic": null } ]

//每天显示出当天的全部浏览记录。下面的浏览记录只是小视频的，其他的暂时没有放入；
//后面需要这样做吗？
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['idStu'];//获取从小程序传递过来的id值，
    $Studentid = 1;
    //$date = $_GET['date'];//获取从小程序传递过来的id值，日期
    $date = '2018-09-12';
    
    //首先查询出所有的小视频的浏览记录；
    //括号里的sql语句：select Student_log_SAVLShortVideoid_FK from mp_wx_zxj_demo_mysql.Student_log_SAVL where Student_log_SAVLStudentid_FK=1 and Student_log_SAVLtime>='2018-09-12 00:00:00' and Student_log_SAVLtime<='2018-09-12 23:59:59' group by Student_log_SAVLShortVideoid_FK order by Student_log_SAVLtime asc;
    //这样写不行，因为括号里的Subquery返回值不止一条；
    //直接拆开，查询某一天中到底浏览了哪些小视频的记录；
    $sql0 = "select Student_log_SAVLShortVideoid_FK from Student_log_SAVL where Student_log_SAVLStudentid_FK=".$Studentid." and Student_log_SAVLtime>='".$date." 00:00:00' and Student_log_SAVLtime<='".$date." 23:59:59' group by Student_log_SAVLShortVideoid_FK order by Student_log_SAVLtime asc";
    mysqli_query($link, "set names 'utf8'");
    $result0 = mysqli_query($link, $sql0);
    
    class myhistory{
        public $id;//这个media的数据库中的id；没有意义，可以不传。
        public $mediaid;//这是media的id值；
        public $SPcount;//Share Page的数量；
        public $medianame;//视频的名字；
        public $Lcount;//Like的数量；
        public $PicURI;//这个视频的图片；
        public $Stuname;//作者的名字；
        public $StuPic;//作者的图片；
    }
    $id=1;
    
    $data = array();
    if (mysqli_num_rows($result0) > 0) {
        while($row0 = mysqli_fetch_assoc($result0)) {
    
            $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI FROM Student_shortVideo_log where idStudent_shortVideo_log=".$row0["Student_log_SAVLShortVideoid_FK"]."";
            mysqli_query($link, "set names 'utf8'");
            $result = mysqli_query($link, $sql);
            //echo($sql);
            
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
                    
                    $myhistory=new myhistory();
                    $myhistory->id=$id++;//对的
                    $myhistory->mediaid=$row["idStudent_shortVideo_log"];//对的
                    
                    while($row2 = mysqli_fetch_assoc($result_Lcount)) {
                        $myhistory->Lcount=$row2["count(*)"];//这个视频被点赞的数量
                    }
                    
                    
                    $myhistory->medianame=$row["Student_shortVideo_logName"];//对的
                    
                    while($row1 = mysqli_fetch_assoc($result_SPcount)) {
                        $myhistory->SPcount=$row1["count(*)"];//这个视频被分享的数量
                    }
                    
                    
                    $myhistory->PicURI=$row["Student_shortVideo_logPICURI"];//对的
                    
                    while($row3 = mysqli_fetch_assoc($result_name_pic)) {
                        $myhistory->Stuname=$row3["StudentName"];
                        $myhistory->StuPic=$row3["Student_wxPic"];
                    }
                    
                    $data[] = $myhistory;
                    //echo($coursein);
                    
                }
            }
            
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
