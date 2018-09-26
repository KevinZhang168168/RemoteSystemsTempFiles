<?php
//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "StuName": "王小虎", "StuPic": null, "Stumedal": "1,2", "Stulevel": "3" }, { "StuName": "米夏全", "StuPic": null, "Stumedal": "2,3", "Stulevel": "2" }, { "StuName": "张三", "StuPic": null, "Stumedal": "3,4", "Stulevel": "3" }, { "StuName": "李四", "StuPic": null, "Stumedal": "4,5", "Stulevel": "4" } ]

//把这个学生对应的班级里所有的同学信息找出来，这个从数据库里提取；
//班级的同学需要展示的等级和勋章从数据库里来；
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
    
    $sql = "select StudentName,Student_wxPic,Studentmedal,Studentlevel from Student where Student_belongto_teacherid=(SELECT Student_belongto_teacherid FROM Student where idStudent=".$Studentid.")";//
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    class ClassStu{
        public $StuName;
        public $StuPic;
        public $Stumedal;
        public $Stulevel;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        //$id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $ClassStu=new ClassStu();
            $ClassStu->StuName=$row["StudentName"];
            $ClassStu->StuPic=$row["Student_wxPic"];
            $ClassStu->Stumedal=$row["Studentmedal"];//勋章可以有多个
            $ClassStu->Stulevel=$row["Studentlevel"];//等级只有一个，数字
            $data[] = $ClassStu;
            
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
