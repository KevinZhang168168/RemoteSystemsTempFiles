<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "idmedia_top3": "1", "mediaid": "1", "SPcount": "11", "medianame": "��һ", "Lcount": "111", "PicURI": "/image/media/lou.png", "Stuname": "����", "StuPic": "/image/media/lou.png" }, { "idmedia_top3": "2", "mediaid": "2", "SPcount": "22", "medianame": "�ڶ�", "Lcount": "222", "PicURI": "/image/media/lou.png", "Stuname": "����", "StuPic": "/image/media/lou.png" }, { "idmedia_top3": "3", "mediaid": "3", "SPcount": "33", "medianame": "����", "Lcount": "333", "PicURI": "/image/media/lou.png", "Stuname": "����", "StuPic": "/image/media/lou.png" } ]

//С��Ƶ��ҳ�ϳ���3����������С��Ƶ����������ݿ�����ȡ��
//�ڷ�������дһ��service��ÿ��1��Сʱ��ͳ�Ƶ���������������С��Ƶ�ŵ�����洢���������ݿ�ѹ���ܼ�С��ÿ��ҳ����ʾ��top3�������ȡ��������ݿ��д洢�����ݿ����㹻��С��Ƶҳ����ʹ���ˣ������ٴζ�ȡ����table��
//ͬʱ���������Ƶ�����ߵ����ֺ�ͼƬҲ��ʾ������
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    $sql = "SELECT * FROM media_top3";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class media_top3{
        public $idmedia_top3;
        public $mediaid;//����media��idֵ��
        public $SPcount;//Share Page��������
        public $medianame;
        public $Lcount;//Like��������
        public $PicURI;//�����Ƶ��ͼƬ��
        public $Stuname;//���ߵ����֣�
        public $StuPic;//���ߵ�ͼƬ��
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $media_top3=new media_top3();
            $media_top3->idmedia_top3=$row["idmedia_top3"];
            $media_top3->mediaid=$row["media_top3mediaid_FK"];
            $media_top3->SPcount=$row["media_top3SPcount"];
            $media_top3->medianame=$row["media_top3name"];
            $media_top3->Lcount=$row["media_top3Lcount"];
            $media_top3->PicURI=$row["media_top3PicURI"];
            $media_top3->Stuname=$row["media_top3Stuname"];
            $media_top3->StuPic=$row["media_top3StuPic"];
            $data[] = $media_top3;
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
