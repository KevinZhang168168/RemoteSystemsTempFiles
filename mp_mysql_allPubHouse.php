<?php

//Kevin Zhang 开发环境测试成功，未连接小程序。
//PHP+MySQL测试结果：[ { "idPubHouse": "1", "PubHouseName": "部编教材" }, { "idPubHouse": "2", "PubHouseName": "人教版" }, { "idPubHouse": "3", "PubHouseName": "师教版" }, { "idPubHouse": "4", "PubHouseName": "北京版" } ]

//数据库中所有的版本，这个暂时可能只有部编版，以后可能会有更多的版本，比如师教版，人教版等等
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['Studentid'];//获取从小程序传递过来的id值，
    
    //idStudent=1暂时按照1代替，实际微信小程序用$Studentid
   
    $sql = "select idPublishing_house,Publishing_houseName from Publishing_house";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class allPubHouse{
        public $idPubHouse;
        public $PubHouseName;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $allPubHouse=new allPubHouse();
            $allPubHouse->idPubHouse=$row["idPublishing_house"];
            $allPubHouse->PubHouseName=$row["Publishing_houseName"];
            $data[] = $allPubHouse;
            //echo($coursein);
        }
        
        //echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//将请求结果转换为json格式
        //echo json_encode($data);
        //echo sizeof($data);
    }
    
}
else{
    echo "db connect failed!";
}

?>
