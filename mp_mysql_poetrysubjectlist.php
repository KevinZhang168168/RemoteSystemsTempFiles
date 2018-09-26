<?php

//Kevin Zhang 开发环境测试成功，未连接小程序。
//PHP+MySQL测试结果：[ { "idPoetry": "5", "PoetryName": "扩展阅读1" }, { "idPoetry": "6", "PoetryName": "扩展阅读2" }, { "idPoetry": "7", "PoetryName": "扩展阅读3" }, { "idPoetry": "8", "PoetryName": "扩展阅读4" }, { "idPoetry": "1", "PoetryName": "月下独酌" }, { "idPoetry": "3", "PoetryName": "村居" }, { "idPoetry": "2", "PoetryName": "登鹳雀楼" }, { "idPoetry": "4", "PoetryName": "静夜思" } ]

//筛选的主题就是诗歌，我们现在把所有学生录制的视频都归类到其中一个诗歌下了。
//这里把数据库中所有的诗歌都列出来，作为主题列表；

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['Studentid'];//获取从小程序传递过来的id值，
    
    //idStudent=1暂时按照1代替，实际微信小程序用$Studentid
    $sql = "select idPoetry,PoetryName from Poetry";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    class PoetryList{
        public $idPoetry;
        public $PoetryName;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $PoetryList=new PoetryList();
            
            $PoetryList->idPoetry=$row["idPoetry"];
            $PoetryList->PoetryName=$row["PoetryName"];
          
            $data[] = $PoetryList;
        }
        
        //还应该有一个学习进度的Json数据返回，我现在文档中写上，这个在php中还没有实现。
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//将请求结果转换为json格式
        //echo json_encode($data);
        //echo sizeof($data);
    }
    
}
else{
    echo "db connect failed!";
}

?>
