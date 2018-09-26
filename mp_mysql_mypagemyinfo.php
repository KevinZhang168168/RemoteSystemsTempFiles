<?php
//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "StuName": "王小虎", "StuPic": null, "Stumedal": "1,2", "Stulevel": "1", "StuSchool": "史家胡同小学", "StuClass": "小学二年级一班" } ]

//把这个学生对应的基本信息找出来，这个从数据库里提取；
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
    
    $sql = "select StudentName,Student_wxPic,Studentmedal,Studentlevel,Student_belongto_classid_FK from Student where idStudent=".$Studentid."";//
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    class Stuinfo{
        public $StuName;
        public $StuPic;
        public $Stumedal;
        public $Stulevel;
        public $StuSchool;
        Public $StuClass;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        //$id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $Stuinfo=new Stuinfo();
            $Stuinfo->StuName=$row["StudentName"];
            $Stuinfo->StuPic=$row["Student_wxPic"];
            $Stuinfo->Stumedal=$row["Studentmedal"];//勋章可以有多个
            $Stuinfo->Stulevel=$row["Studentlevel"];//等级只有一个，数字
            
            $sql1 = "select classname,class_schoolid_FK from class where idclass=".$row["Student_belongto_classid_FK"]."";//
            mysqli_query($link, "set names 'utf8'");
            $result1 = mysqli_query($link, $sql1);
            while($row1 = mysqli_fetch_assoc($result1)) {
                $Stuinfo->StuClass=$row1["classname"];//班级的名字
                
                $sql2 = "select Schoolname from School where idSchool=".$row1["class_schoolid_FK"]."";//
                mysqli_query($link, "set names 'utf8'");
                $result2 = mysqli_query($link, $sql2);
                while($row2 = mysqli_fetch_assoc($result2)) {
                    $Stuinfo->StuSchool=$row2["Schoolname"];//学校的名字
                }
                
            }
            
            $data[] = $Stuinfo;
            
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
