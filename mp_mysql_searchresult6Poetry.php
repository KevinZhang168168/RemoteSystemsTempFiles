<?php
header("Content-Type:text/html;charset=UTF-8");
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "id": 1, "idPoetry": "1", "PoetryName": "���¶���", "idPoetryAuthor": "���", "idPoetryAuthorDynasty": "�Ƴ�", "PoetryContent": "����һ���ƣ����������ס�", "PoetryPicURI": "/image/media/lou.png" }, { "id": 2, "idPoetry": "2", "PoetryName": "����ȸ¥", "idPoetryAuthor": "�׾���", "idPoetryAuthorDynasty": "�Ƴ�", "PoetryContent": "������ɽ�����ƺ��뺣����", "PoetryPicURI": "/image/media/lou.png" }, { "id": 3, "idPoetry": "3", "PoetryName": "���", "idPoetryAuthor": "���", "idPoetryAuthorDynasty": "�Ƴ�", "PoetryContent": "����һ���ƣ����������ס�", "PoetryPicURI": "/image/media/lou.png" }, { "id": 4, "idPoetry": "4", "PoetryName": "��ҹ˼", "idPoetryAuthor": "�׾���", "idPoetryAuthorDynasty": "�Ƴ�", "PoetryContent": "����һ���ƣ����������ס�", "PoetryPicURI": "/image/media/lou.png" }, { "id": 5, "idPoetry": "5", "PoetryName": "Hello", "idPoetryAuthor": "���", "idPoetryAuthorDynasty": "�Ƴ�", "PoetryContent": "����һ���ƣ����������ס�", "PoetryPicURI": "/image/media/lou.png" }, { "id": 6, "idPoetry": "6", "PoetryName": "Hello1", "idPoetryAuthor": "���", "idPoetryAuthorDynasty": "�Ƴ�", "PoetryContent": "����һ���ƣ����������ס�", "PoetryPicURI": "/image/media/lou.png" } ]


//���������ؼ��ʵ����й�ʫ���б������ʾ3����ֻ��ʫ������֣����������ߣ�ʫ�������ĸ��������������ಿ�ֲ�������
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);


if($link){
    //$keyword = $_GET['keyword'];//��ȡ��С���򴫵ݹ����������ؼ���ֵ��
    
    //idStudent=1��ʱ����1���棬ʵ��΢��С������$Studentid
    //$keyword = mb_str_split($keyword);
    $keyword = '��';
    $keyword=mb_convert_encoding($keyword,'UTF-8','GBK');
    
    //echo(mb_check_encoding($keyword));
    //echo( mb_substr($keyword,0,4,"gb2312"));
    //$keyword = implode('',mb_str_split($keyword));
    //echo(mb_str_split($keyword));
    //select idPoetry,PoetryName,idPoetryAuthor_FK,idPoetryAuthorDynasty_FK,PoetryContent,PoetryPic_id_FK from mp_wx_zxj_demo_mysql.Poetry where PoetryName='��';
    //select idPoetry,PoetryName,idPoetryAuthor_FK,idPoetryAuthorDynasty_FK,PoetryContent,PoetryPic_id_FK from mp_wx_zxj_demo_mysql.Poetry where PoetryName like "%��%";
    
    $sql = "select idPoetry,PoetryName,idPoetryAuthor_FK,idPoetryAuthorDynasty_FK,PoetryContent,PoetryPic_id_FK from Poetry where PoetryName like '%".$keyword."%' or idPoetryAuthor_FK like '%".$keyword."%' or idPoetryAuthorDynasty_FK like '%".$keyword."%' or PoetryContent like '%".$keyword."%' limit 0,6";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    //echo($sql);
    
    class PoetryList{
        public $id;
        public $idPoetry;
        public $PoetryName;
        public $idPoetryAuthor;
        public $idPoetryAuthorDynasty;
        public $PoetryContent;
        public $PoetryPicURI;
    }
    $id=1;
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $PoetryList=new PoetryList();
            $PoetryList->id=$id++;
            $PoetryList->idPoetry=$row["idPoetry"];
            $PoetryList->PoetryName=$row["PoetryName"];
            $PoetryList->idPoetryAuthor=$row["idPoetryAuthor_FK"];
            $PoetryList->idPoetryAuthorDynasty=$row["idPoetryAuthorDynasty_FK"];
            $PoetryList->PoetryContent=$row["PoetryContent"];
            $PoetryList->PoetryPicURI=$row["PoetryPic_id_FK"];
            $data[] = $PoetryList;
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
