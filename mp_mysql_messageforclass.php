<?php
//Kevin Zhang 开发环境测试成功，未连接小程序。这里只是显示了消息，没有用户读取消息后存储数据库的功能，在另外的php中实现。
//PHP+MySQL测试结果：[ { "idmessage_for_stu": 1, "messageid_for_stu": "1", "message_name": "语文作业通知", "massage_detail": "语文作业通知" }, { "idmessage_for_stu": 2, "messageid_for_stu": "2", "message_name": "语文预习通知", "massage_detail": "语文作业通知" }, { "idmessage_for_stu": 3, "messageid_for_stu": "3", "message_name": "课后互动通知", "massage_detail": "语文作业通知" } ]

//首页上出现3个这个学生所属班级的消息通知，这个从数据库里提取，时间最近的3个，其余在查看更多里显示
//$name=$_GET["name"];//接收参数
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //echo "db connect success!";
    //$Studentid = $_GET['Studentid'];//获取从小程序传递过来的id值，
    
    //Studentid暂时按照1代替，实际微信小程序用$Studentid
    $Studentid=1;
    $sql1 = "SELECT Student_belongto_classid_FK FROM mp_wx_zxj_demo_mysql.Student where idStudent=".$Studentid."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result1 = mysqli_query($link, $sql1);
    
    class student_classid{
        public $idclass;
    }
    
    $data1 = array();
    if (mysqli_num_rows($result1) > 0) {
        while($row = mysqli_fetch_assoc($result1)) {
            
            $student_classid=new student_classid();
            $student_classid->idclass=$row["Student_belongto_classid_FK"];
            $data1[] = $student_classid;
        }
    }
    
    class sys_mes_class{
        public $idmessage_for_stu;
        public $messageid_for_stu;
        public $message_name;
        public $massage_detail;
    }
    
    $sql = "select idmessage_for_class,message_for_classname,message_for_classdetail from mp_wx_zxj_demo_mysql.message_for_class where message_for_classid_FK = " .$data1[0]->idclass."";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $idmessage_for_stu = 1;
        for ($x=0; $x<=2; $x++) {
            while($row = mysqli_fetch_assoc($result)) {
                $sys_mes_class=new sys_mes_class();
                $sys_mes_class->idmessage_for_stu=$idmessage_for_stu++;//自增+1，这行没有实际意义，只是微信小程序显示的排列顺序
                $sys_mes_class->messageid_for_stu=$row["idmessage_for_class"];//拿到这个message的id值,消息读过后要变色，系统要有记录
                $sys_mes_class->message_name=$row["message_for_classname"];
                $sys_mes_class->massage_detail=$row["message_for_classdetail"];
                $data[] = $sys_mes_class;
            }
            
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//将请求结果转换为json格式
        
    }
    
}
else{
    echo "db connect failed!";
}

?>
