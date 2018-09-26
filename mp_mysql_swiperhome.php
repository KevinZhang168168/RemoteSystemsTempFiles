<?php

//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "idswiper_home": "1", "swiper_uri": "/image/poetry/cunju.png", "swiper_navito": "../poetry/index", "swiper_itemid": "1" }, { "idswiper_home": "2", "swiper_uri": "/image/poetry/cunju.png", "swiper_navito": "../poetry/index", "swiper_itemid": "1" }, { "idswiper_home": "3", "swiper_uri": "/image/poetry/cunju.png", "swiper_navito": "../poetry/index", "swiper_itemid": "1" }, { "idswiper_home": "4", "swiper_uri": "/image/poetry/cunju.png", "swiper_navito": "../poetry/index", "swiper_itemid": "1" }, { "idswiper_home": "5", "swiper_uri": "/image/poetry/cunju.png", "swiper_navito": "../poetry/index", "swiper_itemid": "1" }, { "idswiper_home": "6", "swiper_uri": "/image/poetry/cunju.png", "swiper_navito": "../poetry/index", "swiper_itemid": "2" } ] 

//首页Home上面有个滑块视图容器，这个从数据库里提取
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
    
    $sql = "SELECT *FROM swiper_home";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class swiperhome{
        public $idswiper_home;
        public $swiper_uri;
        public $swiper_navito;
        public $swiper_itemid;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $swiperhome=new swiperhome();
            $swiperhome->idswiper_home=$row["idswiper_home"];
            $swiperhome->swiper_uri=$row["swiper_homeuri"];
            $swiperhome->swiper_navito=$row["swiper_homenavito"];
            $swiperhome->swiper_itemid=$row["swiper_homeitemid"];
            $data[] = $swiperhome;
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