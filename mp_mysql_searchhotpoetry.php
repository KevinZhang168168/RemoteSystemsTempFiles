<?php
//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "idhotestpoetry": 1, "poetry_uri": "/image/poetry/cunju.png", "hotestpoetry_navito": "../poetry/index", "poetryid": "1", "hotestpoetry_count": "3" }, { "idhotestpoetry": 2, "poetry_uri": "/image/poetry/dengguanquelou.png", "hotestpoetry_navito": "../poetry/index", "poetryid": "2", "hotestpoetry_count": "2" } ] 

//首页上出现两个点击量最大的诗歌，这个从数据库里提取
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
    
    //从数据库中查询出学生浏览次数最多的两个诗歌
    $sql_top2 = "SELECT Student_log_PLPoetryid_FK, count(*) FROM student_log_pl group by Student_log_PLPoetryid_FK order by count(*) desc limit 0,2";//重写
    mysqli_query($link, "set names 'utf8'");
    $result_top2 = mysqli_query($link, $sql_top2);
    class hotestpoetry_top2{
        public $idhotestpoetry_PLid;//得到的是诗歌的id值。
        public $idhotestpoetry_PLid_count;//这个值是诗歌被浏览的次数
    }
    //把查询结果放入一个array中做下一步处理。
    $data_top2 = array();
    if (mysqli_num_rows($result_top2) > 0) {
        while($row = mysqli_fetch_assoc($result_top2)) {
            $hotestpoetry_top2=new hotestpoetry_top2();
            $hotestpoetry_top2->idhotestpoetry_PLid=$row["Student_log_PLPoetryid_FK"];//拿到poetry的id值，放入数组
            $hotestpoetry_top2->idhotestpoetry_PLid_count=$row["count(*)"];//拿到poetry的浏览数量值，放入数组
            $data_top2[] = $hotestpoetry_top2;
        }
    }
    
    //$result_top2->close();
    //$link->close();
    //echo (mysqli_num_rows($result_top2));
    //echo json_encode($data_top2,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    //echo ($data_top2);
    
    //下面是给小程序页面的返回值
    //$sql = "select Poetry_picURI from poetry_pic where idPoetry_pic = " ;
    //mysqli_query($link, "set names 'utf8'");
    
    //$result = mysqli_query($link, $sql);
    
    class hotestpoetry{
        public $idhotestpoetry;
        public $poetry_uri;
        public $hotestpoetry_navito;
        public $poetryid;
        public $hotestpoetry_count;
    }
    
    $data = array();
    if (mysqli_num_rows($result_top2) > 0) {
        //echo (mysqli_num_rows($result_top2));
        //echo (mysqli_fetch_assoc($data_top2));
        //while($row = mysqli_fetch_assoc($result_top2)) {
        $idhotestpoetry = 1;
        
        $PLid="";//$link1 = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);
        
        //while($row = mysqli_num_rows($result_top2)) {
        //while($row = mysqli_fetch_assoc($data_top2)) {
        for ($x=0; $x<=1; $x++) {
            //$sql = "select Poetry_picURI from mp_wx_zxj_demo_mysql.poetry_pic where idPoetry_pic = 1"; //$hotestpoetry_top2->idhotestpoetry_PLid=row["Student_log_PLPoetryid_FK"];
            $PLid= $data_top2[$x]->idhotestpoetry_PLid;
            $sql = "select Poetry_picURI from mp_wx_zxj_demo_mysql.poetry_pic where idPoetry_pic = " .$PLid."";
            //echo($sql);
            
            //if($link1) {
            //$link1 = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn);//or trigger_error(mysqli_error(),E_USER_ERROR);
            mysqli_query($link, "set names 'utf8'");
            $result = mysqli_query($link, $sql);
            //echo (mysqli_num_rows($result));
            
            while($row = mysqli_fetch_assoc($result)) {
                $hotestpoetry=new hotestpoetry();
                $hotestpoetry->idhotestpoetry=$idhotestpoetry++;//自增+1
                $hotestpoetry->poetry_uri=$row["Poetry_picURI"];//拿到这个poetry的URI值
                $hotestpoetry->hotestpoetry_navito="../poetry/index";
                $hotestpoetry->poetryid=$data_top2[$x]->idhotestpoetry_PLid;//把这个poetry的ID返回给小程序页面
                $hotestpoetry->hotestpoetry_count=$data_top2[$x]->idhotestpoetry_PLid_count;
                $data[] = $hotestpoetry;
            }
            //echo($coursein);
            //echo (idhotestpoetry);
            //echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        //}
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