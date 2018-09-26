<?php
//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "idhotestsearch": 1, "searchword": "登鹳雀楼" }, { "idhotestsearch": 2, "searchword": "村" }, { "idhotestsearch": 3, "searchword": "楼" }, { "idhotestsearch": 4, "searchword": "局" }, { "idhotestsearch": 5, "searchword": "村居1" }, { "idhotestsearch": 6, "searchword": "等" }, { "idhotestsearch": 7, "searchword": "村居2" }, { "idhotestsearch": 8, "searchword": "村居3" }, { "idhotestsearch": 9, "searchword": "村居4" } ]

//首页上出现9个点击量最大的查询关键词，这个从数据库里提取
//$name=$_GET["name"];//接收参数
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//$link = mysqli_connect("localhost","Kevinzhang","Kevinzhang");
if($link){
    //echo "db connect success!";
    
    $sql = "SELECT search_logkeyword, count(*) FROM mp_wx_zxj_demo_mysql.search_log group by search_logkeyword order by count(*) desc limit 0,9";//重写
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class search9keyword{
        public $idhotestsearch;
        public $searchword;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        
        $idhotestsearch = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $search9keyword=new search9keyword();
            $search9keyword->idhotestsearch=$idhotestsearch++;//不对
            $search9keyword->searchword=$row["search_logkeyword"];//不对
            $data[] = $search9keyword;
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
