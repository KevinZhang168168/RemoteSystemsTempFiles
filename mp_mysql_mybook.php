<?php

//Kevin Zhang 开发环境测试成功，未连接小程序。
//PHP+MySQL测试结果：[ { "idStudentBook": "4", "StudentBookNote": "小学二年级，下册，语文，部编版" } ]

//古诗词首页下方出现用户目前的课本，缺省为小学语文二年级下册，这个从数据库里提取。如果用户重新选择过，则显示用户的选择。
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['Studentid'];//获取从小程序传递过来的id值，
    
    //idStudent=1暂时按照1代替，实际微信小程序用$Studentid
    $Studentid=1;
    $sql = "select idCourse_in_grade,Course_in_gradeNote from Course_in_grade where idCourse_in_grade=(select class_Course_in_gradeFK from class where idclass=(SELECT Student_belongto_classid_FK FROM mp_wx_zxj_demo_mysql.Student where idStudent=".$Studentid."))";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class StudentBook{
        public $idStudentBook;
        public $StudentBookNote;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $StudentBook=new StudentBook();
            $StudentBook->idStudentBook=$row["idCourse_in_grade"];
            $StudentBook->StudentBookNote=$row["Course_in_gradeNote"];
            $data[] = $StudentBook;
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
