<?php
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "StuName": "��С��", "StuPic": null, "Stumedal": "1,2", "Stulevel": "3" }, { "StuName": "����ȫ", "StuPic": null, "Stumedal": "2,3", "Stulevel": "2" }, { "StuName": "����", "StuPic": null, "Stumedal": "3,4", "Stulevel": "3" }, { "StuName": "����", "StuPic": null, "Stumedal": "4,5", "Stulevel": "4" } ]

//�����ѧ����Ӧ�İ༶�����е�ͬѧ��Ϣ�ҳ�������������ݿ�����ȡ��
//�༶��ͬѧ��Ҫչʾ�ĵȼ���ѫ�´����ݿ�������
//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//$link = mysqli_connect("localhost","Kevinzhang","Kevinzhang");
if($link){
    //$Studentid = $_GET['idStu'];//��ȡ��С���򴫵ݹ�����idֵ��
    $Studentid = 1;
    
    $sql = "select StudentName,Student_wxPic,Studentmedal,Studentlevel from Student where Student_belongto_teacherid=(SELECT Student_belongto_teacherid FROM Student where idStudent=".$Studentid.")";//
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    class ClassStu{
        public $StuName;
        public $StuPic;
        public $Stumedal;
        public $Stulevel;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        //$id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $ClassStu=new ClassStu();
            $ClassStu->StuName=$row["StudentName"];
            $ClassStu->StuPic=$row["Student_wxPic"];
            $ClassStu->Stumedal=$row["Studentmedal"];//ѫ�¿����ж��
            $ClassStu->Stulevel=$row["Studentlevel"];//�ȼ�ֻ��һ��������
            $data[] = $ClassStu;
            
        }
        
        //echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//��������ת��Ϊjson��ʽ
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//��������ת��Ϊjson��ʽ
        //echo json_encode($data);
        //echo sizeof($data);
    }
    
}
else{
    echo "db connect failed!";
}

?>
