<?php
header("Content-Type:text/html;charset=UTF-8");
//Kevin Zhang 开发环境测试成功，未连接小程序。
//PHP+MySQL测试结果：[ { "id": 1, "idPoetryEx": "1", "PoetryExName": "村居的扩展阅读1", "idPoetryExAuthor": "李白", "idPoetryExAuthorDynasty": "唐朝", "PoetryExContent": "村居的扩展阅读1", "PoetryExPicURI": "/image/voice/lou.png" }, { "id": 2, "idPoetryEx": "2", "PoetryExName": "村居的扩展阅读2", "idPoetryExAuthor": "李白", "idPoetryExAuthorDynasty": "唐朝", "PoetryExContent": "村居的扩展阅读1", "PoetryExPicURI": "/image/voice/lou.png" }, { "id": 3, "idPoetryEx": "3", "PoetryExName": "村居的扩展阅读3", "idPoetryExAuthor": "李白", "idPoetryExAuthorDynasty": "唐朝", "PoetryExContent": "村居的扩展阅读1", "PoetryExPicURI": "/image/voice/lou.png" } ]


//符合搜索关键词的所有扩展阅读的列表，最多显示3个，只在扩展阅读诗歌的名字，朝代，作者，诗歌内容四个部分搜索，其余部分不搜索。
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);


if($link){
    //$keyword = $_GET['keyword'];//获取从小程序传递过来的搜索关键词值，
    
    $keyword = '阅';
    $keyword=mb_convert_encoding($keyword,'UTF-8','GBK');
    
   
    $sql = "select idPoetry_extended_reading,Poetry_extended_readingname,Poetry_extended_readingauthor,Poetry_extended_readingdynasty,Poetry_extended_readingcentent,Poetry_extended_readingPicURI from Poetry_extended_reading where Poetry_extended_readingname like '%".$keyword."%' or Poetry_extended_readingcentent like '%".$keyword."%' or Poetry_extended_readingdynasty like '%".$keyword."%' or Poetry_extended_readingauthor like '%".$keyword."%' limit 0,3";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    
    class PoetryExList{
        public $id;
        public $idPoetryEx;
        public $PoetryExName;
        public $idPoetryExAuthor;
        public $idPoetryExAuthorDynasty;
        public $PoetryExContent;
        public $PoetryExPicURI;
    }
    $id=1;
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $PoetryExList=new PoetryExList();
            $PoetryExList->id=$id++;
            $PoetryExList->idPoetryEx=$row["idPoetry_extended_reading"];
            $PoetryExList->PoetryExName=$row["Poetry_extended_readingname"];
            $PoetryExList->idPoetryExAuthor=$row["Poetry_extended_readingauthor"];
            $PoetryExList->idPoetryExAuthorDynasty=$row["Poetry_extended_readingdynasty"];
            $PoetryExList->PoetryExContent=$row["Poetry_extended_readingcentent"];
            $PoetryExList->PoetryExPicURI=$row["Poetry_extended_readingPicURI"];
            $data[] = $PoetryExList;
            //echo($coursein);
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
