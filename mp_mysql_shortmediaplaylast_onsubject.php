<?php

//Kevin Zhang �����������Գɹ���δ����С���������û����ɡ�
//PHP+MySQL���Խ����[ { "idmedia_last": null, "mediaid": "2", "SPcount": "1", "medianame": "��С���ĵڶ�����Ƶ", "Lcount": "2", "PicURI": "/image/media/lou.png", "Stuname": "��С��", "StuPic": null, "idmedia_below9": 1 } ]

//С��Ƶ����ҳ�棬ҳ���ϵ�ֵ����Ҫ�����ݿ���ֱ����ȡ�����ܴ���һ��ҳ���ϴ��룬ԭ�������㣺��һ���Ǹ����ݿ϶��������µ����ݣ�
//�ڶ���С��Ƶ��ҳ��ֻ��ʾ��9��С��Ƶ������û���鿴��ʮ������������������ݿ��ѯ���ݣ���Ϊ��ҳ��û��������ݡ�
//�����û��������ҳ�滹��ֻ����mediaidֵ���������ݴ������в��ң�
//���ڵ������ǣ���ҳ��9����Ƶ����ʾ�ǰ���ʱ��Ľ������У�����ҵ�С��Ƶ����һ������һ����Ƶ�أ�
//ֻ����������һ�£������в��У���mp_mysql_shortmediaplaynext.php��ʵ��
//idStudent_shortVideo_log���ֵ��������һ�ģ�ʱ��Լ��ģ����ֵԽ�����ǰ���ʱ�併�����еģ���ˣ���һ���ҾͰ���
//idStudent_shortVideo_log���ֵ+1��ֱ��maxΪֹ����ͷ�ˡ�

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$idMedia = $_GET['idMedia'];//��ȡ��С���򴫵ݹ�����idֵ����ʾС��Ƶ��idֵ��
    //$idStu = $_GET['idStu'];//��ȡ��С���򴫵ݹ�����idֵ����ʾС��Ƶ��idֵ��
    //$idSubject = $_GET['idSubject'];//��ȡ��С���򴫵ݹ�����idֵ����ʾС��Ƶ��idֵ��
    $idMedia = 4;
    $idStu = 1;
    $idSubject = 1;
    
    $sqlmax="SELECT max(idStudent_shortVideo_log) FROM Student_shortVideo_log";
    mysqli_query($link, "set names 'utf8'");
    $resultmax = mysqli_query($link, $sqlmax);
    //echo()
    if (mysqli_fetch_assoc($resultmax)> $idMedia)
    {
        //$idMedia = $idMedia + 1;//�����������idֵС�����ݿ�������ֵ�����һ��
        //����취�ο�����һ��php
        //idStudent_shortVideo_log = (select min(idStudent_shortVideo_log) from Student_shortVideo_log where idStudent_shortVideo_log > ".$idMedia.")";
        if ($idStu == null & $idSubject != null){
            
            //idStuΪ�գ�idSubject��Ϊ�գ���ִ���������ʾ�û�ѡ����һ�����⣻
            $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI FROM Student_shortVideo_log where Student_shortVideo_log_belongtoPoetryID_FK=". $idSubject . "". " and idStudent_shortVideo_log = (select min(idStudent_shortVideo_log) from Student_shortVideo_log where idStudent_shortVideo_log > ".$idMedia.")";
            
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
            
            $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from Student_shortVideo_log where Student_shortVideo_log_Stuid_FK in (select idStudent from Student where Student_belongto_classid_FK=". $classid ."".") and idStudent_shortVideo_log = (select min(idStudent_shortVideo_log) from Student_shortVideo_log where idStudent_shortVideo_log > ".$idMedia.")";
            
        }else if($idStu != null & $idSubject != null){
            
            //idStu��Ϊ�գ�idSubjectΪ�գ���ִ���������ʾ�û�ѡ����һ���༶��ͬ�ࣻ
            //���ȣ���ֻ��ѧ����idֵ��Ҫ�Ȳ�������ڵİ༶��Ȼ��������༶���ж���ͬѧ��Ȼ�������༶������ͬѧ��С��Ƶ�����ҳ�����
            $sql1 = "select Student_belongto_classid_FK from Student where idStudent=".$idStu."";
            mysqli_query($link, "set names 'utf8'");
            $result1 = mysqli_query($link, $sql1);
            //$row1 = $mysqli_fetch_assoc($result1);
            while($row1 = mysqli_fetch_assoc($result1)) {
                $classid=$row1["Student_belongto_classid_FK"];//�õ�����༶��id��
            }
            
            $sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI from Student_shortVideo_log where Student_shortVideo_log_belongtoPoetryID_FK=".$idSubject." and Student_shortVideo_log_Stuid_FK in (select idStudent from Student where Student_belongto_classid_FK=". $classid ."".")  and idStudent_shortVideo_log = (select min(idStudent_shortVideo_log) from Student_shortVideo_log where idStudent_shortVideo_log > ".$idMedia.")";
            
        }
    }
    else{
        return(0);//��ʾû�������ˣ�����0��
        exit;
    }
    
    
    //$sql = "SELECT idStudent_shortVideo_log,Student_shortVideo_log_Stuid_FK,Student_shortVideo_logName,Student_shortVideo_logPICURI FROM Student_shortVideo_log where idStudent_shortVideo_log=".$idMedia."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class media_below9{
        public $idmedia_last;//���media�����ݿ��е�id��û�����壬���Բ�����
        public $mediaid;//����media��idֵ��
        public $SPcount;//Share Page��������
        public $medianame;//��Ƶ�����֣�
        public $Lcount;//Like��������
        public $PicURI;//�����Ƶ��ͼƬ��
        public $Stuname;//���ߵ����֣�
        public $StuPic;//���ߵ�ͼƬ��
    }
    $idmedia_last=1;
    
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
            $media_below9->idmedia_below9=$idmedia_last++;//�Ե�
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
