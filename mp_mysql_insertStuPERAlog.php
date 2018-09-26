<?php
//用户收听了任何扩展阅读的朗读，小程序端给我传过来idStu and idExReadingAudio and Type;
//我在服务器端记录；
//执行sql：INSERT INTO Student_log_PERA SET Student_log_PERAStudentid_FK=1,Student_log_PERAtime='2018-09-17 11:06:32',Student_log_PERAid_FK=1,Student_log_PERAtype=0

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['idStu'];//获取从小程序传递过来的id值，
    //$ExReadingAudioid = $_GET['idExReadingAudio'];//获取从小程序传递过来的id值，
    //$Typeint = $_GET['Type'];//获取从小程序传递过来的id值，
    $Studentid = 1;
    $ExReadingAudioid = 1;
    $Typeint = 0;
    
    //把新计算的数值逐一插入进去；
    $sql_insert = "INSERT INTO Student_log_PERA SET Student_log_PERAStudentid_FK=" .$Studentid."" . ",Student_log_PERAtime='".date('Y-m-d H:i:s',time())."'" . ",Student_log_PERAid_FK=".$ExReadingAudioid."". ",Student_log_PERAtype=".$Typeint."";
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