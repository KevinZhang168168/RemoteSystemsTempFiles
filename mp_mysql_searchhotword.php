<?php
//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "idhotestword": 1, "word_uri": "/image/word/jiu.png", "hotestword_navito": "../word/index", "wordid": "1", "hotestword_count": "4" }, { "idhotestword": 2, "word_uri": "/image/word/lou.png", "hotestword_navito": "../word/index", "wordid": "2", "hotestword_count": "2" } ] 

//首页上出现两个点击量最大的字词，这个从数据库里提取
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //从数据库中查询出学生浏览次数最多的两个字词
    $sql_top2 = "SELECT Student_log_WLWordid_FK, count(*) FROM mp_wx_zxj_demo_mysql.student_log_wl group by Student_log_WLWordid_FK order by count(*) desc limit 0,2";//重写
    mysqli_query($link, "set names 'utf8'");
    $result_top2 = mysqli_query($link, $sql_top2);
    class hotestword_top2{
        public $idhotestword_PLid;//得到的是字词的id值。
        public $idhotestword_PLid_count;//这个值是字词被浏览的次数
    }
    //把查询结果放入一个array中做下一步处理。
    $data_top2 = array();
    if (mysqli_num_rows($result_top2) > 0) {
        while($row = mysqli_fetch_assoc($result_top2)) {
            $hotestword_top2=new hotestword_top2();
            $hotestword_top2->idhotestword_PLid=$row["Student_log_WLWordid_FK"];//拿到word的id值，放入数组
            $hotestword_top2->idhotestWord_PLid_count=$row["count(*)"];//拿到word的浏览数量值，放入数组
            //echo($hotestword_top2->idhotestWord_PLid_count);
            $data_top2[] = $hotestword_top2;
        }
    }
    
    //下面是给小程序页面的返回值
    class hotestword{
        public $idhotestword;
        public $word_uri;
        public $hotestword_navito;
        public $wordid;
        public $hotestword_count;
    }
   
    $data = array();
    if (mysqli_num_rows($result_top2) > 0) {
        $idhotestword = 1;
        for ($x=0; $x<=1; $x++) {
            $sql = "select Word_picURI from mp_wx_zxj_demo_mysql.word_pic where idWord_pic = " .$data_top2[$x]->idhotestword_PLid."";
            mysqli_query($link, "set names 'utf8'");
            $result = mysqli_query($link, $sql);
            
            while($row = mysqli_fetch_assoc($result)) {
                $hotestword=new hotestword();
                $hotestword->idhotestword=$idhotestword++;//自增+1
                $hotestword->word_uri=$row["Word_picURI"];//拿到这个word的URI值
                $hotestword->hotestword_navito="../word/index";
                $hotestword->wordid=$data_top2[$x]->idhotestword_PLid;//把这个word的ID返回给小程序页面
                $hotestword->hotestword_count=$data_top2[$x]->idhotestWord_PLid_count;
                //echo($hotestword_top2->idhotestWord_PLid_count);
                $data[] = $hotestword;
            }
            
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//将请求结果转换为json格式
            
        }
        
}
else{
    echo "db connect failed!";
}

?> 
