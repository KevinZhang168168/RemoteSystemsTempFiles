<?php

//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "idhotestmedia": 1, "media_uri": "/image/media/lou.png", "hotestmedia_navito": null, "mediaid": "1", "hotestmedia_count": null, "hotestword_navito": "../multimedia/index", "hotestword_count": "3" }, { "idhotestmedia": 2, "media_uri": "/image/media/lou.png", "hotestmedia_navito": null, "mediaid": "2", "hotestmedia_count": null, "hotestword_navito": "../multimedia/index", "hotestword_count": "3" } ] 

//首页上出现两个点击量最大的小视频，这个从数据库里提取，这里说的小视频指的是用户自己上传的，包含视频和朗读
//$name=$_GET["name"];//接收参数
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //从数据库中查询出学生浏览次数最多的两个小视频/音频
    $sql_top2 = "SELECT Student_log_SAVLShortVideoid_FK, count(*) FROM mp_wx_zxj_demo_mysql.student_log_SAVL group by Student_log_SAVLShortVideoid_FK order by count(*) desc limit 0,2";//重写
    mysqli_query($link, "set names 'utf8'");
    $result_top2 = mysqli_query($link, $sql_top2);
    class hotestSAV_top2{
        public $idhotestSAV_Lid;//得到的是小视频的id值。
        public $idhotestSAV_Lid_count;//这个值是小视频被浏览的次数
    }
    //把查询结果放入一个array中做下一步处理。
    $data_top2 = array();
    if (mysqli_num_rows($result_top2) > 0) {
        while($row = mysqli_fetch_assoc($result_top2)) {
            $hotestSAV_top2=new hotestSAV_top2();
            $hotestSAV_top2->idhotestSAV_Lid=$row["Student_log_SAVLShortVideoid_FK"];//拿到小视频的id值，放入数组
            $hotestSAV_top2->idhotestSAV_Lid_count=$row["count(*)"];//拿到小视频的浏览数量值，放入数组
            $data_top2[] = $hotestSAV_top2;
        }
    }
    
    
    
    class hotestmedia{
        public $idhotestmedia;
        public $media_uri;
        public $hotestmedia_navito;
        public $mediaid;
        public $hotestmedia_count;
    }
    
    $data = array();
    if (mysqli_num_rows($result_top2) > 0) {
        $idhotestmedia = 1;
        for ($x=0; $x<=1; $x++) {
            $sql = "select Student_shortVideo_contentpicURI from mp_wx_zxj_demo_mysql.Student_shortVideo_content where idStudent_shortVideo_content = " .$data_top2[$x]->idhotestSAV_Lid."";
            mysqli_query($link, "set names 'utf8'");
            $result = mysqli_query($link, $sql);
                        
            while($row = mysqli_fetch_assoc($result)) {
                $hotestmedia=new hotestmedia();
                $hotestmedia->idhotestmedia=$idhotestmedia++;//自增+1
                $hotestmedia->media_uri=$row["Student_shortVideo_contentpicURI"];//拿到这个word的URI值
                $hotestmedia->hotestword_navito="../multimedia/index";
                $hotestmedia->mediaid=$data_top2[$x]->idhotestSAV_Lid;//把这个word的ID返回给小程序页面
                $hotestmedia->hotestword_count=$data_top2[$x]->idhotestSAV_Lid_count;
                $data[] = $hotestmedia;
        }
        
    }
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//将请求结果转换为json格式
    
}

    
}
else{
    echo "db connect failed!";
}

?> 