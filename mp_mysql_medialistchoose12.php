<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����ÿ�����͵Ĳ��Խ�������棻

//С��Ƶ�û�������ɸѡ�󣬰����ϴ���ʱ�併�����У���������ݿ�����ȡ��ÿ�������ʾ12����
//�е��鷳����Ҫɸѡ�ܶ�����
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$idStu = $_GET['idStu'];//��ȡ��С���򴫵ݹ�����idֵ����ʾѧ����id��
    //$idSubject = $_GET['idSubject'];//��ȡ��С���򴫵ݹ�����idֵ����ʾɸѡ������id��
    $idStu = 1;
    $idSubject = 1;
    
    if ($idStu == null & $idSubject != null){
        
        //idStuΪ�գ�idSubject��Ϊ�գ���ִ���������ʾ�û�ѡ����һ�����⣻
        
        $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI FROM Student_shortVideo_log where Student_shortVideo_log_belongtoPoetryID_FK=". $idSubject . "". " order by Student_shortVideo_log_uploadtime DESC limit 0,12";
    
        /*���Խ��
         * *SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI FROM Student_shortVideo_log where Student_shortVideo_log_belongtoPoetryID_FK=1 order by Student_shortVideo_log_uploadtime DESC limit 0,12[ { "idmedia_listchoose12": 1, "mediaid": "1", "SPcount": "2", "medianame": "��С���ĵ�һ����Ƶ", "Lcount": "4", "PicURI": "/image/media/lou.png", "Stuname": "��С��", "StuPic": null }, { "idmedia_listchoose12": 2, "mediaid": "3", "SPcount": "1", "medianame": "����ȫ�ĵ�һ����Ƶ", "Lcount": "2", "PicURI": "/image/media/lou.png", "Stuname": "����ȫ", "StuPic": null }, { "idmedia_listchoose12": 3, "mediaid": "5", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 4, "mediaid": "6", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 5, "mediaid": "7", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 6, "mediaid": "8", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 7, "mediaid": "9", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null } ]
         */
        /*
         * [ { "idmedia_listchoose12": 1, "mediaid": "1", "SPcount": "2", "medianame": "��С���ĵ�һ����Ƶ", "Lcount": "4", "PicURI": "/image/media/lou.png", "Stuname": "��С��", "StuPic": null }, { "idmedia_listchoose12": 2, "mediaid": "3", "SPcount": "1", "medianame": "����ȫ�ĵ�һ����Ƶ", "Lcount": "2", "PicURI": "/image/media/lou.png", "Stuname": "����ȫ", "StuPic": null }, { "idmedia_listchoose12": 3, "mediaid": "5", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 4, "mediaid": "6", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 5, "mediaid": "7", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 6, "mediaid": "8", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 7, "mediaid": "9", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null } ]
         */
        
    }else if($idStu != null & $idSubject == null){
        
        //idStu��Ϊ�գ�idSubjectΪ�գ���ִ���������ʾ�û�ѡ����һ���༶��ͬ�ࣻ
        //���ȣ���ֻ��ѧ����idֵ��Ҫ�Ȳ�������ڵİ༶��Ȼ��������༶���ж���ͬѧ��Ȼ�������༶������ͬѧ��С��Ƶ�����ҳ�����
        $sql1 = "select Student_belongto_classid_FK from Student where idStudent=".$idStu."";
        mysqli_query($link, "set names 'utf8'");
        $result1 = mysqli_query($link, $sql1);
        //$row1 = $mysqli_fetch_assoc($result1);
        while($row1 = mysqli_fetch_assoc($result1)) {
            $classid=$row1["Student_belongto_classid_FK"];//�õ�����༶��id��
        }
        
        /*
        //���˰༶��idֵ����������������༶������ѧ����id��
        $sql2="select idStudent from Student where Student_belongto_classid_FK=".$row1."";
        mysqli_query($link, "set names 'utf8'");
        $result2 = mysqli_query($link, $sql2);//�õ�����༶��id������ѧ����idֵ���Ƕ��ֵ��
        
        //��������ѧ����idֵ���ٰ�����ͬһ����ѧ����С��Ƶ���ҳ�����
        if (mysqli_num_rows($result2) > 0) {
            while($row2 = $mysqli_fetch_assoc($result2)) {
                $sql3 = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from Student_shortVideo_log where idStudent=". $row2[idStudent] .""." order by Student_shortVideo_log_uploadtime DESC limit 0,12";
            }
        }
        */       
        /*
         * SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from mp_wx_zxj_demo_mysql.Student_shortVideo_log where Student_shortVideo_log_Stuid_FK in (select idStudent from mp_wx_zxj_demo_mysql.Student where Student_belongto_classid_FK=1) order by Student_shortVideo_log_uploadtime DESC limit 0,12;
         */
        /*
         * [ { "idmedia_listchoose12": 1, "mediaid": "1", "SPcount": "2", "medianame": "��С���ĵ�һ����Ƶ", "Lcount": "4", "PicURI": "/image/media/lou.png", "Stuname": "��С��", "StuPic": null }, { "idmedia_listchoose12": 2, "mediaid": "2", "SPcount": "1", "medianame": "��С���ĵڶ�����Ƶ", "Lcount": "2", "PicURI": "/image/media/lou.png", "Stuname": "��С��", "StuPic": null }, { "idmedia_listchoose12": 3, "mediaid": "5", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 4, "mediaid": "6", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 5, "mediaid": "7", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 6, "mediaid": "8", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 7, "mediaid": "9", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 8, "mediaid": "10", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null } ]
         */
        
        $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from Student_shortVideo_log where Student_shortVideo_log_Stuid_FK in (select idStudent from Student where Student_belongto_classid_FK=". $classid ."".") order by Student_shortVideo_log_uploadtime DESC limit 0,12";
        //echo($sql);
    }else if($idStu != null & $idSubject != null){
        /*
        //idStu��Ϊ�գ�idSubject��Ϊ�գ���ִ���������ʾ�û�ѡ����һ���༶��ͬ�࣬ͬʱѡ����һ�����⣻
        //idStu��Ϊ�գ�idSubjectΪ�գ���ִ���������ʾ�û�ѡ����һ���༶��ͬ�ࣻ
        //���ȣ���ֻ��ѧ����idֵ��Ҫ�Ȳ�������ڵİ༶��Ȼ��������༶���ж���ͬѧ��Ȼ�������༶������ͬѧ��С��Ƶ�����ҳ�����
        $sql1 = "select Student_belongto_classid_FK from Student where idStudent=".$idStu."";
        mysqli_query($link, "set names 'utf8'");
        $result1 = mysqli_query($link, $sql1);
        $row1 = $mysqli_fetch_assoc($result1);//�õ�����༶��id��
        
        //���˰༶��idֵ����������������༶������ѧ����id��
        $sql2="select idStudent from Student where Student_belongto_classid_FK=".$row1."";
        mysqli_query($link, "set names 'utf8'");
        $result2 = mysqli_query($link, $sql2);//�õ�����༶��id������ѧ����idֵ���Ƕ��ֵ��
        
        //��������ѧ����idֵ���ٰ�����ͬһ����ѧ����С��Ƶ���ҳ�����
        if (mysqli_num_rows($result2) > 0) {
            while($row2 = $mysqli_fetch_assoc($result2)) {
                $sql3 = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from Student_shortVideo_log where idStudent=". $row2[idStudent] ."" order by Student_shortVideo_log_uploadtime DESC limit 0,12";
            }
        }       
        */
        //idStu��Ϊ�գ�idSubjectΪ�գ���ִ���������ʾ�û�ѡ����һ���༶��ͬ�ࣻ
        //���ȣ���ֻ��ѧ����idֵ��Ҫ�Ȳ�������ڵİ༶��Ȼ��������༶���ж���ͬѧ��Ȼ�������༶������ͬѧ��С��Ƶ�����ҳ�����
        $sql1 = "select Student_belongto_classid_FK from Student where idStudent=".$idStu."";
        mysqli_query($link, "set names 'utf8'");
        $result1 = mysqli_query($link, $sql1);
        //$row1 = $mysqli_fetch_assoc($result1);
        while($row1 = mysqli_fetch_assoc($result1)) {
            $classid=$row1["Student_belongto_classid_FK"];//�õ�����༶��id��
        }
        
        /*
         * SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from mp_wx_zxj_demo_mysql.Student_shortVideo_log where Student_shortVideo_log_belongtoPoetryID_FK=1 and Student_shortVideo_log_Stuid_FK in (select idStudent from mp_wx_zxj_demo_mysql.Student where Student_belongto_classid_FK=1) order by Student_shortVideo_log_uploadtime DESC limit 0,12;
         */
        /*
         * [ { "idmedia_listchoose12": 1, "mediaid": "1", "SPcount": "2", "medianame": "��С���ĵ�һ����Ƶ", "Lcount": "4", "PicURI": "/image/media/lou.png", "Stuname": "��С��", "StuPic": null }, { "idmedia_listchoose12": 2, "mediaid": "5", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 3, "mediaid": "6", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 4, "mediaid": "7", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 5, "mediaid": "8", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null }, { "idmedia_listchoose12": 6, "mediaid": "9", "SPcount": "0", "medianame": "��������Ƶ", "Lcount": "0", "PicURI": null, "Stuname": "����", "StuPic": null } ]
         */
        
        $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from Student_shortVideo_log where Student_shortVideo_log_belongtoPoetryID_FK=".$idSubject." and Student_shortVideo_log_Stuid_FK in (select idStudent from Student where Student_belongto_classid_FK=". $classid ."".") order by Student_shortVideo_log_uploadtime DESC limit 0,12";
        //echo($sql);
    }
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class media_below9{
        public $idmedia_listchoose12;//���media�����ݿ��е�id��û�����壬���Բ�����
        public $mediaid;//����media��idֵ��
        public $SPcount;//Share Page��������
        public $medianame;//��Ƶ�����֣�
        public $Lcount;//Like��������
        public $PicURI;//�����Ƶ��ͼƬ��
        public $Stuname;//���ߵ����֣�
        public $StuPic;//���ߵ�ͼƬ��
    }
    $idmedia_listchoose12=1;
    
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
            $media_below9->idmedia_listchoose12=$idmedia_listchoose12++;//�Ե�
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
