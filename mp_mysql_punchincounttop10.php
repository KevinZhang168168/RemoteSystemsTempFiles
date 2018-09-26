<?php
//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "id": 1, "Studentname": "王小虎", "count": "10" }, { "id": 2, "Studentname": "李四", "count": "4" }, { "id": 3, "Studentname": "米夏全", "count": "3" }, { "id": 4, "Studentname": "张三", "count": "3" } ]

//哪个学生历史上打卡次数最多的前十名，这个从数据库里提取
//$name=$_GET["name"];//接收参数
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//$link = mysqli_connect("localhost","Kevinzhang","Kevinzhang");
if($link){
    //echo "db connect success!";
    //SELECT Student_log_PunchinidStu_FK, count(*) FROM mp_wx_zxj_demo_mysql.Student_log_Punchin group by Student_log_PunchinidStu_FK order by count(*) desc limit 0,10;
    $sql = "SELECT Student_log_PunchinidStu_FK, count(*) FROM Student_log_Punchin group by Student_log_PunchinidStu_FK order by count(*) desc limit 0,10";//
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class searchtop10punchin{
        public $id;
        public $Studentname;
        public $count;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $sql1 = "select StudentName from Student where idStudent=".$row["Student_log_PunchinidStu_FK"]."";//
            mysqli_query($link, "set names 'utf8'");
            $result1 = mysqli_query($link, $sql1);
            
            $searchtop10punchin=new searchtop10punchin();
            $searchtop10punchin->id=$id++;//可以不要；
            while($row1 = mysqli_fetch_assoc($result1)) {
                $searchtop10punchin->Studentname=$row1["StudentName"];//不对
            }
            
            $searchtop10punchin->count=$row["count(*)"];
            $data[] = $searchtop10punchin;
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
