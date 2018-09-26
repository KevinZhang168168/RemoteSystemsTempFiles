<?php

//Kevin Zhang 开发环境测试成功，未连接小程序
//把诗歌中间部分都提取出来，除了知识大爆炸部分；
//PHP+MySQL测试结果：[ { "PoetryAuthorNote": "花间一壶酒，独酌无相亲。", "PoetryZonglan": "花间一壶酒，独酌无相亲。", "PoetryFJSY": "花间一壶酒，独酌无相亲。", "PoetrySFDB": "花间一壶酒，独酌无相亲。", "PoetrySFDB1": "花间一壶酒，独酌无相亲。" } ] 

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
    $sql = "SELECT PoetryAuthorNote,PoetryZonglan,PoetryFJSY,PoetrySFDB,PoetrySFDB1 FROM Poetry where idPoetry=".$idPoetry."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class poetrynote{
        public $PoetryAuthorNote;
        public $PoetryZonglan;
        public $PoetryFJSY;
        public $PoetrySFDB;
        public $PoetrySFDB1;
        
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $poetrynote=new poetrynote();
            $poetrynote->PoetryAuthorNote=$row["PoetryAuthorNote"];
            $poetrynote->PoetryZonglan=$row["PoetryZonglan"];
            $poetrynote->PoetryFJSY=$row["PoetryFJSY"];
            $poetrynote->PoetrySFDB=$row["PoetrySFDB"];
            $poetrynote->PoetrySFDB1=$row["PoetrySFDB1"];
            
            $data[] = $poetrynote;
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