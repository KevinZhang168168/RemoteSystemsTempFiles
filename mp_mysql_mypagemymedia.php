<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "id": 1, "mediaid": "5", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": "/image/media/lou.png", "Stuname": "����", "StuPic": null }, { "id": 2, "mediaid": "6", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": "/image/media/lou.png", "Stuname": "����", "StuPic": null }, { "id": 3, "mediaid": "7", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": "/image/media/lou.png", "Stuname": "����", "StuPic": null }, { "id": 4, "mediaid": "8", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": "/image/media/lou.png", "Stuname": "����", "StuPic": null }, { "id": 5, "mediaid": "9", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": "/image/media/lou.png", "Stuname": "����", "StuPic": null }, { "id": 6, "mediaid": "10", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": "/image/media/lou.png", "Stuname": "����", "StuPic": null } ]

//С��Ƶ6С��Ƶ�������ϴ���ʱ�併�����У���������ݿ�����ȡ��ÿ�������ʾ6����
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['idStu'];//��ȡ��С���򴫵ݹ�����idֵ��
    $Studentid = 3;
    
    $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI FROM Student_shortVideo_log where Student_shortVideo_log_Stuid_FK=".$Studentid." order by Student_shortVideo_log_uploadtime DESC limit 0,6";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class media_below9{
        public $id;//���media�����ݿ��е�id��û�����壬���Բ�����
        public $mediaid;//����media��idֵ��
        public $SPcount;//Share Page��������
        public $medianame;//��Ƶ�����֣�
        public $Lcount;//Like��������
        public $PicURI;//�����Ƶ��ͼƬ��
        public $Stuname;//���ߵ����֣�
        public $StuPic;//���ߵ�ͼƬ��
    }
    $id=1;
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            //�����Ƶ�����������
            $sql_SPcount = "SELECT count(*) FROM mp_wx_zxj_demo_mysql.student_log_SP where Student_log_SPid_FK="  .$row["idStudent_shortVideo_log"]."" ;//��д
            mysqli_query($link, "set names 'utf8'");
            $result_SPcount = mysqli_query($link, $sql_SPcount);
            
            //�����Ƶ�����޵�����
            $sql_Lcount = "SELECT count(*) FROM mp_wx_zxj_demo_mysql.student_log_L where Student_log_Lid_FK="  .$row["idStudent_shortVideo_log"]."" ;//��д
            mysqli_query($link, "set names 'utf8'");
            $result_Lcount = mysqli_query($link, $sql_Lcount);
            
            //�����Ƶ���ߵ����ֺ�ͷ��
            $sql_name_pic = "select StudentName,Student_wxPic from student where idStudent="  .$row["Student_shortVideo_log_Stuid_FK"]."";//��д
            mysqli_query($link, "set names 'utf8'");
            $result_name_pic = mysqli_query($link, $sql_name_pic);
            
            $media_below9=new media_below9();
            $media_below9->id=$id++;//�Ե�
            $media_below9->mediaid=$row["idStudent_shortVideo_log"];//�Ե�
            
            while($row2 = mysqli_fetch_assoc($result_Lcount)) {
                $media_below9->Lcount=$row2["count(*)"];//�����Ƶ�����޵�����
            }
            
            
            $media_below9->medianame=$row["Student_shortVideo_logName"];//�Ե�
            
            while($row1 = mysqli_fetch_assoc($result_SPcount)) {
                $media_below9->SPcount=$row1["count(*)"];//�����Ƶ�����������
            }
            
            
            $media_below9->PicURI=$row["Student_shortVideo_logPICURI"];//�Ե�
            
            while($row3 = mysqli_fetch_assoc($result_name_pic)) {
                $media_below9->Stuname=$row3["StudentName"];
                $media_below9->StuPic=$row3["Student_wxPic"];
            }
            
            
            $data[] = $media_below9;
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
