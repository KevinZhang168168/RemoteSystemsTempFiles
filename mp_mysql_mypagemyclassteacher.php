<?php
//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "TeacherName": "张老师", "TeacherPic": null } ]

//把这个学生对应的老师信息找出来，这个从数据库里提取；
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
    
    $sql = "select Teachername,Teacher_wxPic from Teacher where idTeacher=(SELECT Student_belongto_teacherid FROM Student where idStudent=".$Studentid.")";//
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    class ClassTeacher{
        public $TeacherName;
        public $TeacherPic;
        
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        //$id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $ClassTeacher=new ClassTeacher();
            
            $ClassTeacher->TeacherName=$row["Teachername"];
            $ClassTeacher->TeacherPic=$row["Teacher_wxPic"];
            $data[] = $ClassTeacher;
            
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
