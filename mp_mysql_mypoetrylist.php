<?php

//Kevin Zhang �����������Գɹ���δ����С����ѧϰ���ȵ�Json����û�У�Ŀǰ��С�����log�д洢��������ѧϰ���ȣ�����洢���������ˡ�
//���Ҫ��һ�����򣬿��Ա�С������ã���С����ı���log�ļ��ж�ȡѧϰ���ȣ����ϴ���������Ӧ����ÿ���û���¼��ʱ���ϴ����ص�ѧϰ���ȣ���ʾ����һ���˳����ѧϰ���ȣ�
//ÿ���û��˳���ʱ��Ҳ�ϴ�������С����ܶ������ϵͳkill������̵ģ���˲�һ����ִ�б����ϴ�������
//����û�û�б��ص�ѧϰ���ȣ����ʾ��Ҫô���ǵ�һ�ε�¼��Ҫô�����ǻ����ֻ��������޼�¼���Ƿ������м�¼�����С����Ӧ��������������󣬶�ȡѧϰ���ȣ�
//�������������ѧϰ���ȣ���С����д��˽��ȵ�����log���������������Ϊ�գ����ʾ���û������û���
//PHP+MySQL���Խ����[ { "id": 1, "idPoetry": "1", "PoetryName": "���¶���", "idPoetryAuthor": "���", "idPoetryAuthorDynasty": "�Ƴ�", "PoetryContent": "����һ���ƣ����������ס�", "PoetryPicURI": "/image/media/lou.png" }, { "id": 2, "idPoetry": "2", "PoetryName": "����ȸ¥", "idPoetryAuthor": "�׾���", "idPoetryAuthorDynasty": "�Ƴ�", "PoetryContent": "������ɽ�����ƺ��뺣����", "PoetryPicURI": "/image/media/lou.png" }, { "id": 3, "idPoetry": "3", "PoetryName": "���", "idPoetryAuthor": "���", "idPoetryAuthorDynasty": "�Ƴ�", "PoetryContent": "����һ���ƣ����������ס�", "PoetryPicURI": "/image/media/lou.png" }, { "id": 4, "idPoetry": "4", "PoetryName": "��ҹ˼", "idPoetryAuthor": "�׾���", "idPoetryAuthorDynasty": "�Ƴ�", "PoetryContent": "����һ���ƣ����������ס�", "PoetryPicURI": "/image/media/lou.png" } ]

//��ʫ����ҳ�·������û�Ŀǰ�Ŀα������й�ʫ���б�
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['Studentid'];//��ȡ��С���򴫵ݹ�����idֵ��
    
    //idStudent=1��ʱ����1���棬ʵ��΢��С������$Studentid
    $Studentid=1;
    $sql = "select idPoetry,PoetryName,idPoetryAuthor_FK,idPoetryAuthorDynasty_FK,PoetryContent,PoetryPic_id_FK from Poetry where idCourse_in_grade_PubHouse_Poetry_FK=(select idCourse_in_grade from Course_in_grade where idCourse_in_grade=(select class_Course_in_gradeFK from class where idclass=(SELECT Student_belongto_classid_FK FROM mp_wx_zxj_demo_mysql.Student where idStudent=".$Studentid.")))";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
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
