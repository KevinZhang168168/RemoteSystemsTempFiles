<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "id": 1, "mediaid": "1", "SPcount": "2", "medianame": "��С���ĵ�һ����Ƶ", "Lcount": "4", "PicURI": "/image/media/lou.png", "Stuname": "��С��", "StuPic": null }, { "id": 2, "mediaid": "2", "SPcount": "1", "medianame": "��С���ĵڶ�����Ƶ", "Lcount": "2", "PicURI": "/image/media/lou.png", "Stuname": "��С��", "StuPic": null } ]

//ÿ����ʾ�������ȫ�������¼������������¼ֻ��С��Ƶ�ģ���������ʱû�з��룻
//������Ҫ��������
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['idStu'];//��ȡ��С���򴫵ݹ�����idֵ��
    $Studentid = 1;
    //$date = $_GET['date'];//��ȡ��С���򴫵ݹ�����idֵ������
    $date = '2018-09-12';
    
    //���Ȳ�ѯ�����е�С��Ƶ�������¼��
    //�������sql��䣺select Student_log_SAVLShortVideoid_FK from mp_wx_zxj_demo_mysql.Student_log_SAVL where Student_log_SAVLStudentid_FK=1 and Student_log_SAVLtime>='2018-09-12 00:00:00' and Student_log_SAVLtime<='2018-09-12 23:59:59' group by Student_log_SAVLShortVideoid_FK order by Student_log_SAVLtime asc;
    //����д���У���Ϊ�������Subquery����ֵ��ֹһ����
    //ֱ�Ӳ𿪣���ѯĳһ���е����������ЩС��Ƶ�ļ�¼��
    $sql0 = "select Student_log_SAVLShortVideoid_FK from Student_log_SAVL where Student_log_SAVLStudentid_FK=".$Studentid." and Student_log_SAVLtime>='".$date." 00:00:00' and Student_log_SAVLtime<='".$date." 23:59:59' group by Student_log_SAVLShortVideoid_FK order by Student_log_SAVLtime asc";
    mysqli_query($link, "set names 'utf8'");
    $result0 = mysqli_query($link, $sql0);
    
    class myhistory{
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
    if (mysqli_num_rows($result0) > 0) {
        while($row0 = mysqli_fetch_assoc($result0)) {
    
            $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI FROM Student_shortVideo_log where idStudent_shortVideo_log=".$row0["Student_log_SAVLShortVideoid_FK"]."";
            mysqli_query($link, "set names 'utf8'");
            $result = mysqli_query($link, $sql);
            //echo($sql);
            
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
                    
                    $myhistory=new myhistory();
                    $myhistory->id=$id++;//�Ե�
                    $myhistory->mediaid=$row["idStudent_shortVideo_log"];//�Ե�
                    
                    while($row2 = mysqli_fetch_assoc($result_Lcount)) {
                        $myhistory->Lcount=$row2["count(*)"];//�����Ƶ�����޵�����
                    }
                    
                    
                    $myhistory->medianame=$row["Student_shortVideo_logName"];//�Ե�
                    
                    while($row1 = mysqli_fetch_assoc($result_SPcount)) {
                        $myhistory->SPcount=$row1["count(*)"];//�����Ƶ�����������
                    }
                    
                    
                    $myhistory->PicURI=$row["Student_shortVideo_logPICURI"];//�Ե�
                    
                    while($row3 = mysqli_fetch_assoc($result_name_pic)) {
                        $myhistory->Stuname=$row3["StudentName"];
                        $myhistory->StuPic=$row3["Student_wxPic"];
                    }
                    
                    $data[] = $myhistory;
                    //echo($coursein);
                    
                }
            }
            
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
