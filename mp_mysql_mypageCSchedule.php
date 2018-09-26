<?php
//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "id": 1, "firstclass": "数学，语文，外语，数学，语文", "secondclass": "数学，语文，外语，数学，语文", "thirdclass": "数学，语文，外语，数学，语文", "fourthclass": "数学，语文，外语，数学，语文", "addamclass": "数学，语文，外语，数学，语文", "fifthclass": "数学，语文，外语，数学，语文", "sixthclass": "数学，语文，外语，数学，语文", "addpm1class": "数学，语文，外语，数学，语文", "addpm2class": "数学，语文，外语，数学，语文" } ]

//把学生的课表从数据库中提取出来，缺省没有，如果有，最多可以提取出9条记录，这个从数据库里提取；
//第一个记录是第一节课的顺序是从周一到周五；以此类推；
//上午可以自定义第五节课，也提取出来，空的就空的，小程序页面自己判断；
//也就是说上午最多可以有五节课；
//下午有两节课，用户可以自定义两节课，也就是下午最多有四节课；
//$name=$_GET["name"];//接收参数
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//$link = mysqli_connect("localhost","Kevinzhang","Kevinzhang");
if($link){
    //$Studentid = $_GET['idStu'];//获取从小程序传递过来的id值，
    $Studentid = 1;
    
    $sql = "SELECT Student_log_CSchedulefirstclass,Student_log_CSchedulesecondclass,Student_log_CSchedulethirdclass,Student_log_CSchedulefourthclass,Student_log_CScheduleaddam,Student_log_CSchedulefifthclass,Student_log_CSchedulesixthclass,Student_log_CScheduleaddpm1,Student_log_CScheduleaddpm2 FROM Student_log_CSchedule where Student_log_CSchedulestuid_FK=".$Studentid."";//
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class StuCSchedule{
        public $id;
        public $firstclass;
        public $secondclass;
        public $thirdclass;
        public $fourthclass;
        public $addamclass;//上午的加课
        public $fifthclass;
        public $sixthclass;
        public $addpm1class;//下午的第一节加课
        public $addpm2class;//下午的第二节加课
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $StuCSchedule=new StuCSchedule();
            
            $StuCSchedule->id=$id++;
            $StuCSchedule->firstclass=$row["Student_log_CSchedulefirstclass"];
            $StuCSchedule->secondclass=$row["Student_log_CSchedulesecondclass"];
            $StuCSchedule->thirdclass=$row["Student_log_CSchedulethirdclass"];
            $StuCSchedule->fourthclass=$row["Student_log_CSchedulefourthclass"];
            $StuCSchedule->addamclass=$row["Student_log_CScheduleaddam"];
            $StuCSchedule->fifthclass=$row["Student_log_CSchedulefifthclass"];
            $StuCSchedule->sixthclass=$row["Student_log_CSchedulesixthclass"];
            $StuCSchedule->addpm1class=$row["Student_log_CScheduleaddpm1"];
            $StuCSchedule->addpm2class=$row["Student_log_CScheduleaddpm2"];
            $data[] = $StuCSchedule;
            //echo($coursein);
        }
        
        //echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式
        //echo json_encode($data);
        //echo sizeof($data);
    }
    
}
else{
    echo "db connect failed!";
}

?>
