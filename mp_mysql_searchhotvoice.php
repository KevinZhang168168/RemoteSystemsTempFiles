<?php
//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "idhotestvoice": 1, "voice_uri": "/image/voice/lou.png", "hotestvoice_navito": "../voice/index", "voiceid": "1", "hotestvoice_count": "5" }, { "idhotestvoice": 2, "voice_uri": "/image/voice/lou.png", "hotestvoice_navito": "../voice/index", "voiceid": "2", "hotestvoice_count": "2" } ] 

//首页上出现两个点击量最大的朗诵音频，这个从数据库里提取，除了8首科内的诗歌，其余的诗歌都是只有声音，没有视频的，这里指的是这些只有朗诵音频的
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
    //从数据库中查询出学生浏览次数最多的两个朗读
    $sql_top2 = "SELECT Student_log_PERAid_FK, count(*) FROM mp_wx_zxj_demo_mysql.Student_log_PERA group by Student_log_PERAid_FK order by count(*) desc limit 0,2";//重写
    mysqli_query($link, "set names 'utf8'");
    $result_top2 = mysqli_query($link, $sql_top2);
    class hotestpoetryPERA_top2{
        public $idhotestPERA_id;//得到的是朗读的id值。
        public $idhotestPEXA_id_count;//这个值是朗读被浏览的次数
    }
    //把查询结果放入一个array中做下一步处理。
    $data_top2 = array();
    if (mysqli_num_rows($result_top2) > 0) {
        while($row = mysqli_fetch_assoc($result_top2)) {
            $hotestpoetryPERA_top2=new hotestpoetryPERA_top2();
            $hotestpoetryPERA_top2->idhotestPERA_id=$row["Student_log_PERAid_FK"];//拿到poetry的id值，放入数组
            $hotestpoetryPERA_top2->idhotestPERA_id_count=$row["count(*)"];//拿到poetry的浏览数量值，放入数组
            $data_top2[] = $hotestpoetryPERA_top2;
        }
    }
    
   
    
    class hotestvoice{
        public $idhotestvoice;
        public $voice_uri;
        public $hotestvoice_navito;
        public $voiceid;
        public $hotestvoice_count;
    }
    
   
    $data = array();
    if (mysqli_num_rows($result_top2) > 0) {
        $idhotestvoice = 1;
        for ($x=0; $x<=1; $x++) {
            //echo($data_top2[$x]->idhotestPERA_id);
            $sql = "select Poetry_extended_readingPicURI from mp_wx_zxj_demo_mysql.Poetry_extended_reading where idPoetry_extended_reading = " .$data_top2[$x]->idhotestPERA_id."";
            mysqli_query($link, "set names 'utf8'");
            $result = mysqli_query($link, $sql);
            
            while($row = mysqli_fetch_assoc($result)) {
                $hotestvoice=new hotestvoice();
                $hotestvoice->idhotestvoice=$idhotestvoice++;//自增+1
                $hotestvoice->voice_uri=$row["Poetry_extended_readingPicURI"];//拿到这个word的URI值
                $hotestvoice->hotestvoice_navito="../voice/index";
                $hotestvoice->voiceid=$data_top2[$x]->idhotestPERA_id;//把这个word的ID返回给小程序页面
                $hotestvoice->hotestvoice_count=$data_top2[$x]->idhotestPERA_id_count;
                $data[] = $hotestvoice;
            }
            
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//将请求结果转换为json格式
        
    }
    
}
else{
    echo "db connect failed!";
}

?> 