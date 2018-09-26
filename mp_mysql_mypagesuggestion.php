<?php
//用户提了任何意见；
//我在服务器端记录；
//执行sql：INSERT INTO Student_log_suggestion SET Student_log_suggestionStuid_FK=1,Student_log_suggestionname='kdjaf汉字汉字',Student_log_suggestionnote='ddkskfkjdjfsdaklfjdskflds汉字汉字',Student_log_suggestiontime='2018-09-24 17:51:02'

header("Content-Type:text/html;charset=utf-8");//这个没用，使用下面的方法，mb_convert_encoding

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['idStu'];//获取从小程序传递过来的id值，
    //$SugName = $_GET['SugName'];//获取从小程序传递过来的id值，
    //$SugNote = $_GET['SugNote'];//获取从小程序传递过来的id值，
    $Studentid = 1;
    $SugName = mb_convert_encoding('kdjaf汉字汉字','UTF-8','GBK');
    $SugNote = mb_convert_encoding('ddkskfkjdjfsdaklfjdskflds汉字汉字','UTF-8','GBK');
    
    //把新计算的数值逐一插入进去；
    //INSERT INTO mp_wx_zxj_demo_mysql.Student_log_suggestion SET Student_log_suggestionStuid_FK=1,Student_log_suggestionname='kdjaf',Student_log_suggestionnote='',Student_log_suggestiontime='2018-09-24 17:40:03';
    $sql_insert = "INSERT INTO Student_log_suggestion SET Student_log_suggestionStuid_FK=" .$Studentid."" . ",Student_log_suggestionname='".$SugName."'" . ",Student_log_suggestionnote='".$SugNote."'" . ",Student_log_suggestiontime='".date('Y-m-d H:i:s',time())."'";
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