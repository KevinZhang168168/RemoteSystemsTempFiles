<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "idswiper_course": "1", "swiper_uri": "/image/poetry/cunju.png", "swiper_navito": "../poetry/index", "swiper_itemid": "1" }, { "idswiper_course": "2", "swiper_uri": "/image/poetry/cunju.png", "swiper_navito": "../poetry/index", "swiper_itemid": "1" }, { "idswiper_course": "3", "swiper_uri": "/image/poetry/cunju.png", "swiper_navito": "../poetry/index", "swiper_itemid": "1" }, { "idswiper_course": "4", "swiper_uri": "/image/poetry/cunju.png", "swiper_navito": "../poetry/index", "swiper_itemid": "1" }, { "idswiper_course": "5", "swiper_uri": "/image/poetry/cunju.png", "swiper_navito": "../poetry/index", "swiper_itemid": "2" }, { "idswiper_course": "6", "swiper_uri": "/image/poetry/cunju.png", "swiper_navito": "../poetry/index", "swiper_itemid": "2" } ] 

//�γ�ҳ��Course�����и�������ͼ��������������ݿ�����ȡ
//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//$link = mysqli_connect("localhost","Kevinzhang","Kevinzhang");
if($link){
    //echo "db connect success!";
    
    $sql = "SELECT *FROM swiper_course";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class swipercourse{
        public $idswiper_course;
        public $swiper_uri;
        public $swiper_navito;
        public $swiper_itemid;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $swipercourse=new swipercourse();
            $swipercourse->idswiper_course=$row["idswiper_course"];
            $swipercourse->swiper_uri=$row["swiper_courseuri"];
            $swipercourse->swiper_navito=$row["swiper_coursenavito"];
            $swipercourse->swiper_itemid=$row["swiper_courseitemid"];
            $data[] = $swipercourse;
            //echo($coursein);
        }
        
        //echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//��������ת��Ϊjson��ʽ
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//��������ת��Ϊjson��ʽ
        //echo json_encode($data);
        //echo sizeof($data);
    }
    
}
else{
    echo "db connect failed!";
}

?> 