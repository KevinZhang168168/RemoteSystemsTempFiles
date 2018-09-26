<?php
//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "id": 1, "levelName": "书童", "levelpic": null }, { "id": 2, "levelName": "弱冠少年", "levelpic": null }, { "id": 3, "levelName": "秀才", "levelpic": null }, { "id": 4, "levelName": "举人", "levelpic": null }, { "id": 5, "levelName": "进士", "levelpic": null }, { "id": 6, "levelName": "探花", "levelpic": null }, { "id": 7, "levelName": "榜眼", "levelpic": null }, { "id": 8, "levelName": "状元", "levelpic": null } ]

//把这个学生对应的等级信息找出来，这个从数据库里提取；然后把所有的等级的名称和图片也找出来，按照用户当前的等级给出图片，到了的等级是彩色的，没到的是灰化的；
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
    
    $sql = "select Student_levelname,Student_levelpic_HL,Student_levelpic_ashing from Student_level";//
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    $sql0 = "select Studentlevel from Student where idStudent=".$Studentid."";//
    mysqli_query($link, "set names 'utf8'");
    $result0 = mysqli_query($link, $sql0);
    
    class Levelinfo{
        public $id;
        public $levelName;
        public $levelpic;
        
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $Levelinfo=new Levelinfo();
            $Levelinfo->id=$id++;
            $Levelinfo->levelName=$row["Student_levelname"];
            
            if (mysqli_num_rows($result0) > 0) {
                while($row0 = mysqli_fetch_assoc($result0)) {
                    if ($row0["Studentlevel"]>=$id){
                        $Levelinfo->levelpic=$row["Student_levelpic_HL"];
                    }else{
                        $Levelinfo->levelpic=$row["Student_levelpic_ashing"];
                    }
                }
            }   
            
            $data[] = $Levelinfo;
            
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
