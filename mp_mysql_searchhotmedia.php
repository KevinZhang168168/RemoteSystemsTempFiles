<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "idhotestmedia": 1, "media_uri": "/image/media/lou.png", "hotestmedia_navito": null, "mediaid": "1", "hotestmedia_count": null, "hotestword_navito": "../multimedia/index", "hotestword_count": "3" }, { "idhotestmedia": 2, "media_uri": "/image/media/lou.png", "hotestmedia_navito": null, "mediaid": "2", "hotestmedia_count": null, "hotestword_navito": "../multimedia/index", "hotestword_count": "3" } ] 

//��ҳ�ϳ����������������С��Ƶ����������ݿ�����ȡ������˵��С��Ƶָ�����û��Լ��ϴ��ģ�������Ƶ���ʶ�
//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //�����ݿ��в�ѯ��ѧ�����������������С��Ƶ/��Ƶ
    $sql_top2 = "SELECT Student_log_SAVLShortVideoid_FK, count(*) FROM mp_wx_zxj_demo_mysql.student_log_SAVL group by Student_log_SAVLShortVideoid_FK order by count(*) desc limit 0,2";//��д
    mysqli_query($link, "set names 'utf8'");
    $result_top2 = mysqli_query($link, $sql_top2);
    class hotestSAV_top2{
        public $idhotestSAV_Lid;//�õ�����С��Ƶ��idֵ��
        public $idhotestSAV_Lid_count;//���ֵ��С��Ƶ������Ĵ���
    }
    //�Ѳ�ѯ�������һ��array������һ������
    $data_top2 = array();
    if (mysqli_num_rows($result_top2) > 0) {
        while($row = mysqli_fetch_assoc($result_top2)) {
            $hotestSAV_top2=new hotestSAV_top2();
            $hotestSAV_top2->idhotestSAV_Lid=$row["Student_log_SAVLShortVideoid_FK"];//�õ�С��Ƶ��idֵ����������
            $hotestSAV_top2->idhotestSAV_Lid_count=$row["count(*)"];//�õ�С��Ƶ���������ֵ����������
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
                $hotestmedia->idhotestmedia=$idhotestmedia++;//����+1
                $hotestmedia->media_uri=$row["Student_shortVideo_contentpicURI"];//�õ����word��URIֵ
                $hotestmedia->hotestword_navito="../multimedia/index";
                $hotestmedia->mediaid=$data_top2[$x]->idhotestSAV_Lid;//�����word��ID���ظ�С����ҳ��
                $hotestmedia->hotestword_count=$data_top2[$x]->idhotestSAV_Lid_count;
                $data[] = $hotestmedia;
        }
        
    }
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//��������ת��Ϊjson��ʽ
    
}

    
}
else{
    echo "db connect failed!";
}

?> 