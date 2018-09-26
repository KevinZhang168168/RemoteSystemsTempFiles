<?php
//用户点赞了任何小视频，小程序端给我传过来idStu and idPoetry；
//我在服务器端记录；
//执行sql：INSERT INTO Student_log_L SET Student_log_Lstuid_FK=1,Student_log_Ltime='2018-09-16 21:09:02',Student_log_Lid_FK=1

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['idStu'];//获取从小程序传递过来的id值，
    //$Mediaid = $_GET['idMedia'];//获取从小程序传递过来的id值，
    $Studentid = 1;
    $Mediaid = 1;
    
    //把新计算的数值逐一插入进去；
    $sql_insert = "INSERT INTO Student_log_L SET Student_log_Lstuid_FK=" .$Studentid."" . ",Student_log_Ltime='".date('Y-m-d H:i:s',time())."'" . ",Student_log_Lid_FK=".$Mediaid."";
    //echo($sql_insert);
    mysqli_query($link, "set names 'utf8'");
    $result_insert = mysqli_query($link, $sql_insert);
    
    //$data[] = $media_top3service;
    echo( $sql_insert);
    
    
    //echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式
    //echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//将请求结果转换为json格式
    //echo json_encode($data);
    //echo sizeof($data);
    
    
}
else{
    echo "db connect failed!";
}


?>