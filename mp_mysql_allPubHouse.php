<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "idPubHouse": "1", "PubHouseName": "����̲�" }, { "idPubHouse": "2", "PubHouseName": "�˽̰�" }, { "idPubHouse": "3", "PubHouseName": "ʦ�̰�" }, { "idPubHouse": "4", "PubHouseName": "������" } ]

//���ݿ������еİ汾�������ʱ����ֻ�в���棬�Ժ���ܻ��и���İ汾������ʦ�̰棬�˽̰�ȵ�
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['Studentid'];//��ȡ��С���򴫵ݹ�����idֵ��
    
    //idStudent=1��ʱ����1���棬ʵ��΢��С������$Studentid
   
    $sql = "select idPublishing_house,Publishing_houseName from Publishing_house";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class allPubHouse{
        public $idPubHouse;
        public $PubHouseName;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $allPubHouse=new allPubHouse();
            $allPubHouse->idPubHouse=$row["idPublishing_house"];
            $allPubHouse->PubHouseName=$row["Publishing_houseName"];
            $data[] = $allPubHouse;
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
