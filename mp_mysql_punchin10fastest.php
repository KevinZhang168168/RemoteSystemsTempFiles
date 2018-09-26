<?php
//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "id": 1, "Studentname": "王小虎", "fastesttime": "17" }, { "id": 2, "Studentname": "王小虎", "fastesttime": "37" }, { "id": 3, "Studentname": "王小虎", "fastesttime": "57" }, { "id": 4, "Studentname": "王小虎", "fastesttime": "17" }, { "id": 5, "Studentname": "王小虎", "fastesttime": "37" }, { "id": 6, "Studentname": "王小虎", "fastesttime": "57" }, { "id": 7, "Studentname": "王小虎", "fastesttime": "17" }, { "id": 8, "Studentname": "张三", "fastesttime": "17" }, { "id": 9, "Studentname": "李四", "fastesttime": "17" }, { "id": 10, "Studentname": "米夏全", "fastesttime": "17" } ]

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
    //SELECT *, ABS(NOW() - startTime)  AS diffTime
    //FROM PolicyShuPrice
    //ORDER BY diffTime ASC
    //LIMIT 0, 1
    
    //SELECT *, abs(UNIX_TIMESTAMP(start_time)-UNIX_TIMESTAMP('2017-02-22')) as min from t_service_orders where user_id=7 GROUP BY min desc
    //需要重写，需要得到的值是每天距离下午六点最近的值；所以应该搜索的是按照每天重新搜索，搜索每天从下午6点到凌晨12点期间哪个上传时间距离6点最近；
    //然后再在所有的搜索结果中排序，哪个差值最小；
    $sql = "SELECT Student_log_PunchinidStu_FK, ABS(NOW() - Student_log_Punchindate)  AS diffTime FROM Student_log_Punchin order by diffTime desc limit 0,10";//
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class searchtop10punchinfastest{
        public $id;
        public $Studentname;
        public $fastesttime;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $sql1 = "select StudentName from Student where idStudent=".$row["Student_log_PunchinidStu_FK"]."";//
            mysqli_query($link, "set names 'utf8'");
            $result1 = mysqli_query($link, $sql1);
            
            $searchtop10punchinfastest=new searchtop10punchinfastest();
            $searchtop10punchinfastest->id=$id++;//可以不要；
            while($row1 = mysqli_fetch_assoc($result1)) {
                $searchtop10punchinfastest->Studentname=$row1["StudentName"];
            }
            
            $searchtop10punchinfastest->fastesttime=strftime('%S',$row["diffTime"]);//这个不对
            $data[] = $searchtop10punchinfastest;
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
