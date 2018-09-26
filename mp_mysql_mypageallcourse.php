<?php
//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "id": 1, "coursename": "语文" }, { "id": 2, "coursename": "数学" }, { "id": 3, "coursename": "英语" }, { "id": 4, "coursename": "思想品德" }, { "id": 5, "coursename": "美术" }, { "id": 6, "coursename": "音乐" }, { "id": 7, "coursename": "京剧" }, { "id": 8, "coursename": "中医" }, { "id": 9, "coursename": "航模" }, { "id": 10, "coursename": "机器人" } ]

//把数据库中所有已经定义好的课程展示出来，包括课内和课外的，最多可以提取出9条记录，这个从数据库里提取；
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
    //$Studentid = 1;
    
    $sql = "SELECT CourseName FROM Course_in";//
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    
    
    class StuCourse{
        public $id;
        public $coursename;
       
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $StuCourse=new StuCourse();
            
            $StuCourse->id=$id++;
            $StuCourse->coursename=$row["CourseName"];
            $data[] = $StuCourse;
           
        }
        
        $sql1 = "SELECT Course_outName FROM Course_out";//
        mysqli_query($link, "set names 'utf8'");
        $result1 = mysqli_query($link, $sql1);
        while($row1 = mysqli_fetch_assoc($result1)) {
            $StuCourse=new StuCourse();
            
            $StuCourse->id=$id++;
            $StuCourse->coursename=$row1["Course_outName"];
            $data[] = $StuCourse;
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
