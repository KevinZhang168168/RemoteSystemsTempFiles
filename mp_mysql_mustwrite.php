<?php

//Kevin Zhang 开发环境测试成功，未连接小程序
//因为字的页面是从古诗页面过去的，所以我把这个古诗里面需要会写的字放到一起了；
//PHP+MySQL测试结果：[ { "poetrymustwrite": "花,间" } ] 这个没有带拼音，因为突然想起来，这个值其实古诗页面中已经有了，不必再次向服务器请求。

//$name=$_GET["name"];//接收参数
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//提取一个诗歌的视频内容
if($link){
    //idPoetry = $_GET['idPoetry'];//获取从小程序传递过来的id值，
    
    //idPoetry=1暂时按照1代替，实际微信小程序用idPoetry
    $sql = "SELECT Poetrymustwrite FROM Poetry where idPoetry=1";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class poetrycontent{
        public $poetrymustwrite;
        
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $poetrycontent=new poetrycontent();
            $poetrycontent->poetrymustwrite=$row["Poetrymustwrite"];
           
      
            $data[] = $poetrycontent;
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
