<?php
//����Ҫдһ��Service��ÿ��ֻ�ڹ̶���ʱ���ڶ�ȡ���ݺ�д��media_top3;���������Ҫ����Linux crontab�У���δ���롣
//ÿ���賿2�㣬�����ݿ��������������С��Ƶ�������ݿ���media_top3��
//Linux crontab��ʱִ������
//���磺00 02 * * * /usr/bin/php -f /home/wwwroot/default/test/serviceMediatop3.php
//��Ȼ��Ϊ���û��ĸ���ʹ�����飬���Խ��������ÿ��ִ�ж�Σ�

//��������ݿ��ж�ȡ����ֵΪ��[ { "idmedia_top3service": 1, "mediaid": "2", "SPcount": "1", "medianame": "��С���ĵڶ�����Ƶ", "Lcount": "5", "PicURI": "/image/media/lou.png", "Stuname": "��С��", "StuPic": null }, { "idmedia_top3service": 2, "mediaid": "1", "SPcount": "2", "medianame": "��С���ĵ�һ����Ƶ", "Lcount": "4", "PicURI": "/image/media/lou.png", "Stuname": "��С��", "StuPic": null }, { "idmedia_top3service": 3, "mediaid": "3", "SPcount": "1", "medianame": "����ȫ�ĵ�һ����Ƶ", "Lcount": "2", "PicURI": "/image/media/lou.png", "Stuname": "����ȫ", "StuPic": null } ]
//��media_top3��������գ�Ȼ���������������insert��ȥ��
//������������£�
//INSERT INTO media_top3 SET media_top3mediaid_FK=2,media_top3SPcount=1,media_top3name='��С���ĵڶ�����Ƶ',media_top3PicURI='/image/media/lou.png',media_top3Lcount=5,media_top3Stuname='��С��',media_top3StuPic=''
//INSERT INTO media_top3 SET media_top3mediaid_FK=1,media_top3SPcount=2,media_top3name='��С���ĵ�һ����Ƶ',media_top3PicURI='/image/media/lou.png',media_top3Lcount=4,media_top3Stuname='��С��',media_top3StuPic=''
//INSERT INTO media_top3 SET media_top3mediaid_FK=3,media_top3SPcount=1,media_top3name='����ȫ�ĵ�һ����Ƶ',media_top3PicURI='/image/media/lou.png',media_top3Lcount=2,media_top3Stuname='����ȫ',media_top3StuPic=''

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //��Student_log_L���ҵ�������������������Ʒ��idֵ�͵�������
    $sql = "SELECT Student_log_Lid_FK,count(*) FROM Student_log_L group by Student_log_Lid_FK order by count(*) DESC limit 0,3";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class media_top3service{
        public $idmedia_top3service;//���media�����ݿ��е�id��û�����壬���Բ�����
        public $mediaid;//����media��idֵ��
        public $SPcount;//Share Page��������
        public $medianame;//��Ƶ�����֣�
        public $Lcount;//Like��������
        public $PicURI;//�����Ƶ��ͼƬ��
        public $Stuname;//���ߵ����֣�
        public $StuPic;//���ߵ�ͼƬ��
    }
    $idmedia_top3service=1;
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        //�Ȱ�media_top3������ɾ����
        $sql_delete = "delete FROM media_top3";
        mysqli_query($link, "set names 'utf8'");
        $result_delete = mysqli_query($link, $sql_delete);
        
        while($row = mysqli_fetch_assoc($result)) {
            
            //�����Ƶ�����������
            $sql_SPcount = "SELECT count(*) FROM student_log_SP where Student_log_SPid_FK="  .$row["Student_log_Lid_FK"]."" ;
            mysqli_query($link, "set names 'utf8'");
            $result_SPcount = mysqli_query($link, $sql_SPcount);
            
            //�����Ƶ�����ֺ�ͼƬ
            $sql_Lcount = "SELECT Student_shortVideo_logName,Student_shortVideo_logPICURI FROM Student_shortVideo_log where idStudent_shortVideo_log="  .$row["Student_log_Lid_FK"]."" ;
            mysqli_query($link, "set names 'utf8'");
            $result_Lcount = mysqli_query($link, $sql_Lcount);
            
            //�����Ƶ���ߵ����ֺ�ͷ��
            $sql_name_pic = "select StudentName,Student_wxPic from student where idStudent=(select Student_shortVideo_log_Stuid_FK from Student_shortVideo_log where idStudent_shortVideo_log="  .$row["Student_log_Lid_FK"].")";
            mysqli_query($link, "set names 'utf8'");
            $result_name_pic = mysqli_query($link, $sql_name_pic);
            
            $media_top3service=new media_top3service();
            $media_top3service->idmedia_top3service=$idmedia_top3service++;//�Ե�
            $media_top3service->mediaid=$row["Student_log_Lid_FK"];//�Ե�
            
            $media_top3service->Lcount=$row["count(*)"];//�����Ƶ�����޵�����
            
            while($row1 = mysqli_fetch_assoc($result_SPcount)) {
                $media_top3service->SPcount=$row1["count(*)"];//�����Ƶ�����������
            }
            
            while($row2 = mysqli_fetch_assoc($result_Lcount)) {
                $media_top3service->medianame=$row2["Student_shortVideo_logName"];//С��Ƶ������
                $media_top3service->PicURI=$row2["Student_shortVideo_logPICURI"];//С��Ƶ��ͼƬ
            }
            
            while($row3 = mysqli_fetch_assoc($result_name_pic)) {
                $media_top3service->Stuname=$row3["StudentName"];
                $media_top3service->StuPic=$row3["Student_wxPic"];
            }
            
            //���¼������ֵ��һ�����ȥ��
            $sql_insert = "INSERT INTO media_top3 SET media_top3mediaid_FK=" .$row["Student_log_Lid_FK"]."" . ",media_top3SPcount=".$media_top3service->SPcount."" . ",media_top3name='".$media_top3service->medianame."'".",media_top3PicURI='".$media_top3service->PicURI."'".",media_top3Lcount=".$row["count(*)"]."".",media_top3Stuname='".$media_top3service->Stuname."'".",media_top3StuPic='".$media_top3service->StuPic."'";
            echo($sql_insert);
            mysqli_query($link, "set names 'utf8'");
            $result_insert = mysqli_query($link, $sql_insert);
            
            $data[] = $media_top3service;
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