<?php

//Kevin Zhang 开发环境测试成功，未连接小程序。这里只是显示了消息，没有用户读取消息后存储数据库的功能，在另外的php中实现。
//这里也是这样的问题，用户读取了消息后，未读和已读的记录在小程序本地的log文件中，需要择机上传服务器端；
//应该也是在用户每次登录后上传，表示上一次退出的时候的状态。
//每次用户退出的时候也上传，但是小程序很多情况是系统kill这个进程的，因此不一定能执行本次上传操作。
//PHP+MySQL测试结果：[ { "id": 1, "idsys_message": "1", "sys_messagename": "系统消息1", "sys_messagedetail": "系统消息1" }, { "id": 2, "idsys_message": "2", "sys_messagename": "系统消息1", "sys_messagedetail": "系统消息1" }, { "id": 3, "idsys_message": "3", "sys_messagename": "系统消息1", "sys_messagedetail": "系统消息1" } ]

//首页上出现3个系统消息，这个从数据库里提取，时间最近的3个，其余在显示更多里。

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //echo "db connect success!";
    //$Studentid = $_GET['Studentid'];//获取从小程序传递过来的id值，
    
    //按照系统消息的时间降序排列
    $sql = "SELECT idsystem_message,system_messagename,system_messagedetail FROM mp_wx_zxj_demo_mysql.system_message order by system_messagetime DESC limit 0,3";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class sys_message{
        public $id;
        public $idsys_message;
        public $sys_messagename;
        public $sys_messagedetail;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $sys_message=new sys_message();
            $sys_message->id=$id++;
            $sys_message->idsys_message=$row["idsystem_message"];
            $sys_message->sys_messagename=$row["system_messagename"];
            $sys_message->sys_messagedetail=$row["system_messagedetail"];
            $data[] = $sys_message;
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
