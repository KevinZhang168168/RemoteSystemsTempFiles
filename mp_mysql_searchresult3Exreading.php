<?php
header("Content-Type:text/html;charset=UTF-8");
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "id": 1, "idPoetryEx": "1", "PoetryExName": "��ӵ���չ�Ķ�1", "idPoetryExAuthor": "���", "idPoetryExAuthorDynasty": "�Ƴ�", "PoetryExContent": "��ӵ���չ�Ķ�1", "PoetryExPicURI": "/image/voice/lou.png" }, { "id": 2, "idPoetryEx": "2", "PoetryExName": "��ӵ���չ�Ķ�2", "idPoetryExAuthor": "���", "idPoetryExAuthorDynasty": "�Ƴ�", "PoetryExContent": "��ӵ���չ�Ķ�1", "PoetryExPicURI": "/image/voice/lou.png" }, { "id": 3, "idPoetryEx": "3", "PoetryExName": "��ӵ���չ�Ķ�3", "idPoetryExAuthor": "���", "idPoetryExAuthorDynasty": "�Ƴ�", "PoetryExContent": "��ӵ���չ�Ķ�1", "PoetryExPicURI": "/image/voice/lou.png" } ]


//���������ؼ��ʵ�������չ�Ķ����б������ʾ3����ֻ����չ�Ķ�ʫ������֣����������ߣ�ʫ�������ĸ��������������ಿ�ֲ�������
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);


if($link){
    //$keyword = $_GET['keyword'];//��ȡ��С���򴫵ݹ����������ؼ���ֵ��
    
    $keyword = '��';
    $keyword=mb_convert_encoding($keyword,'UTF-8','GBK');
    
   
    $sql = "select idPoetry_extended_reading,Poetry_extended_readingname,Poetry_extended_readingauthor,Poetry_extended_readingdynasty,Poetry_extended_readingcentent,Poetry_extended_readingPicURI from Poetry_extended_reading where Poetry_extended_readingname like '%".$keyword."%' or Poetry_extended_readingcentent like '%".$keyword."%' or Poetry_extended_readingdynasty like '%".$keyword."%' or Poetry_extended_readingauthor like '%".$keyword."%' limit 0,3";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    
    class PoetryExList{
        public $id;
        public $idPoetryEx;
        public $PoetryExName;
        public $idPoetryExAuthor;
        public $idPoetryExAuthorDynasty;
        public $PoetryExContent;
        public $PoetryExPicURI;
    }
    $id=1;
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $PoetryExList=new PoetryExList();
            $PoetryExList->id=$id++;
            $PoetryExList->idPoetryEx=$row["idPoetry_extended_reading"];
            $PoetryExList->PoetryExName=$row["Poetry_extended_readingname"];
            $PoetryExList->idPoetryExAuthor=$row["Poetry_extended_readingauthor"];
            $PoetryExList->idPoetryExAuthorDynasty=$row["Poetry_extended_readingdynasty"];
            $PoetryExList->PoetryExContent=$row["Poetry_extended_readingcentent"];
            $PoetryExList->PoetryExPicURI=$row["Poetry_extended_readingPicURI"];
            $data[] = $PoetryExList;
            //echo($coursein);
        }
        
        //��Ӧ����һ��ѧϰ���ȵ�Json���ݷ��أ��������ĵ���д�ϣ������php�л�û��ʵ�֡�
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//��������ת��Ϊjson��ʽ
        //echo json_encode($data);
        //echo sizeof($data);
    }
    
}
else{
    echo "db connect failed!";
}

?>
