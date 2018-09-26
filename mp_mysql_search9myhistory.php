<?php
//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "idmyhistorysearch": 1, "mysearchword": "登鹳雀楼" }, { "idmyhistorysearch": 2, "mysearchword": "楼" }, { "idmyhistorysearch": 3, "mysearchword": "村居1" }, { "idmyhistorysearch": 4, "mysearchword": "村居2" }, { "idmyhistorysearch": 5, "mysearchword": "村居3" }, { "idmyhistorysearch": 6, "mysearchword": "村居4" }, { "idmyhistorysearch": 7, "mysearchword": "等" }, { "idmyhistorysearch": 8, "mysearchword": "村居" }, { "idmyhistorysearch": 9, "mysearchword": "一" } ]

//首页上出现9个用户自己的查询关键词，这个从数据库里提取，时间最近的9个
//$name=$_GET["name"];//接收参数
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //echo "db connect success!";
    //$Studentid = $_GET['Studentid'];//获取从小程序传递过来的id值，
    
    //search_logStudentid_FK=1暂时按照1代替，实际微信小程序用$Studentid
    $Studentid=1;
    $sql = "SELECT search_logkeyword FROM mp_wx_zxj_demo_mysql.search_log where search_logStudentid_FK=".$Studentid." group by search_logkeyword order by search_logtime desc limit 0,9";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class search9myhistory{
        public $idmyhistorysearch;
        public $mysearchword;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $idmyhistorysearch = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $search9myhistory=new search9myhistory();
            $search9myhistory->idmyhistorysearch=$idmyhistorysearch++;//不对
            $search9myhistory->mysearchword=$row["search_logkeyword"];//不对
            $data[] = $search9myhistory;
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
