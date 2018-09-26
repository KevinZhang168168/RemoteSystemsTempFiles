<?php

//Kevin Zhang 开发环境测试成功，未连接小程序
//把诗歌的扩展阅读从另外一个table中找出来，这里只要列出id和名字就可以了。在扩展阅读浏览界面展示全部内容。
//PHP+MySQL测试结果：[ { "Poetryexid": "1", "Poetryexname": "村居的扩展阅读1" }, { "Poetryexid": "2", "Poetryexname": "村居的扩展阅读2" }, { "Poetryexid": "3", "Poetryexname": "村居的扩展阅读3" }, { "Poetryexid": "4", "Poetryexname": "村居的扩展阅读4" } ] 

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
    $idPoetry=1;
    $sql = "SELECT idPoetry_extended_reading,Poetry_extended_readingname FROM Poetry_extended_reading where Poetry_extended_readingPoetryid_FK=".$idPoetry."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class poetryexreading{
        public $Poetryexid;
        public $Poetryexname;
       
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $poetryexreading=new poetryexreading();
            $poetryexreading->Poetryexid=$row["idPoetry_extended_reading"];
            $poetryexreading->Poetryexname=$row["Poetry_extended_readingname"];
           
            $data[] = $poetryexreading;
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