<?php
//这个我就不记录了，小程序后台的数据分析里已经很全了，下面的逻辑也没有写，暂时作废。
//用户登录和登出的时间，小程序端给我传过来idStu and logintime and logouttime；
//我在服务器端记录；
//执行sql：

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['idStu'];//获取从小程序传递过来的id值，
    //$logintime = $_GET['logintime'];//获取从小程序传递过来的id值，
    //$logouttime = $_GET['logouttime'];//获取从小程序传递过来的id值，
    $Studentid = 1;
    
    
    //把新计算的数值逐一插入进去；
    $sql_insert = "INSERT INTO search_log SET search_logStudentid_FK=" .$Studentid."" . ",search_logtime='".date('Y-m-d H:i:s',time())."'" . ",search_logkeyword='".$KeyWord."'";
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