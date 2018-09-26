<?php
//用户播放了任何诗歌的视频，小程序端给我传过来idStu and idPoetry and StartPoint；
//我在服务器端记录；
//执行sql：INSERT INTO Student_log_PV SET Student_log_PVStudentid_FK=1,Student_log_PVtime='2018-09-17 09:11:48',Student_log_PVPoetryid_FK=1,Student_log_PVstartpoint=50

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['idStu'];//获取从小程序传递过来的id值，
    //$idPoetry  = $_GET['idPoetry'];//获取从小程序传递过来的id值，
    //$StartPoint = $_GET['StartPoint'];//获取从小程序传递过来的id值，
    $Studentid = 1;
    $idPoetry = 1;
    $StartPoint = 50;
    
    //把新计算的数值逐一插入进去；
    $sql_insert = "INSERT INTO Student_log_PV SET Student_log_PVStudentid_FK=" .$Studentid."" . ",Student_log_PVtime='".date('Y-m-d H:i:s',time())."'" . ",Student_log_PVPoetryid_FK=".$idPoetry."". ",Student_log_PVstartpoint=".$StartPoint."";
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