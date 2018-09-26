<?php

//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "Wordcontent": "酒", "Wordspell": "hé", "Wordstrokes": "14", "Wordsentence_making": "昨天晚上喝了很多酒，醉了。", "idWordstructure_FK": "1", "Wordmeaning": "用粮食酿酒", "Wordidiom": "对酒当歌", "WordBushou": null, "WordYinxu": null, "WordPicURI": null } ] 
//这里不包含笔顺，笔顺单独提取；

//$name=$_GET["name"];//接收参数
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//提取一个诗歌的视频内容
if($link){
    //$idword = $_GET['idword'];//获取从小程序传递过来的id值，
    
    //idword=1暂时按照1代替，实际微信小程序用idword
    $idword=1;
    $sql = "SELECT Wordcontent,Wordspell,Wordstrokes,Wordsentence_making,idWordstructure_FK,Wordmeaning,Wordidiom,WordBushou,WordYinxu,WordPicURI FROM Word where idWord=".$idword."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class wordcontent{
        public $Wordcontent;
        public $Wordspell;
        public $Wordstrokes;
        public $Wordsentence_making;
        public $idWordstructure_FK;
        
        public $Wordmeaning;
        public $Wordidiom;
        public $WordBushou;
        public $WordYinxu;
        public $WordPicURI;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $wordcontent=new wordcontent();
            $wordcontent->Wordcontent=$row["Wordcontent"];
            $wordcontent->Wordspell=$row["Wordspell"];
            $wordcontent->Wordstrokes=$row["Wordstrokes"];
            $wordcontent->Wordsentence_making=$row["Wordsentence_making"];
            $wordcontent->idWordstructure_FK=$row["idWordstructure_FK"];
            $wordcontent->Wordmeaning=$row["Wordmeaning"];
            $wordcontent->Wordidiom=$row["Wordidiom"];
            $wordcontent->WordBushou=$row["WordBushou"];
            $wordcontent->WordYinxu=$row["WordYinxu"];
            $wordcontent->WordPicURI=$row["WordPicURI"];
            
            
            //$wordcontent->wordPinyin=$pinyin;
            
            
            $data[] = $wordcontent;
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