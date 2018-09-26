<?php

//Kevin Zhang 开发环境测试成功，未连接小程序
//把诗歌的知识大爆炸的点从另外一个table中找出来
//PHP+MySQL测试结果：[ { "Poetryknowname": "知识大爆炸知识点1", "Poetryknownote": "知识点内容1", "Poetryknowpic1": null, "Poetryknowpic2": null }, { "Poetryknowname": "知识大爆炸知识点1", "Poetryknownote": "知识点内容1", "Poetryknowpic1": null, "Poetryknowpic2": null }, { "Poetryknowname": "知识大爆炸知识点1", "Poetryknownote": "知识点内容1", "Poetryknowpic1": null, "Poetryknowpic2": null }, { "Poetryknowname": "知识大爆炸知识点1", "Poetryknownote": "知识点内容1", "Poetryknowpic1": null, "Poetryknowpic2": null }, { "Poetryknowname": "知识大爆炸知识点1", "Poetryknownote": "知识点内容1", "Poetryknowpic1": null, "Poetryknowpic2": null }, { "Poetryknowname": "知识大爆炸知识点1", "Poetryknownote": "知识点内容1", "Poetryknowpic1": null, "Poetryknowpic2": null }, { "Poetryknowname": "知识大爆炸知识点1", "Poetryknownote": "知识点内容1", "Poetryknowpic1": null, "Poetryknowpic2": null } ]

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
    $sql = "SELECT Poetry_knowledgename,Poetry_knowledgenote,Poetry_knowledgepic1,Poetry_knowledgepic2 FROM Poetry_knowledge where Poetry_knowledgeid_FK=".$idPoetry."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class poetryknowledge{
        public $Poetryknowname;
        public $Poetryknownote;
        public $Poetryknowpic1;
        public $Poetryknowpic2;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $poetryknowledge=new poetryknowledge();
            $poetryknowledge->Poetryknowname=$row["Poetry_knowledgename"];
            $poetryknowledge->Poetryknownote=$row["Poetry_knowledgenote"];
            $poetryknowledge->Poetryknowpic1=$row["Poetry_knowledgepic1"];
            $poetryknowledge->Poetryknowpic2=$row["Poetry_knowledgepic2"];
            $data[] = $poetryknowledge;
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