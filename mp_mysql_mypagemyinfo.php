<?php
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "StuName": "��С��", "StuPic": null, "Stumedal": "1,2", "Stulevel": "1", "StuSchool": "ʷ�Һ�ͬСѧ", "StuClass": "Сѧ���꼶һ��" } ]

//�����ѧ����Ӧ�Ļ�����Ϣ�ҳ�������������ݿ�����ȡ��
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
    
    $sql = "select StudentName,Student_wxPic,Studentmedal,Studentlevel,Student_belongto_classid_FK from Student where idStudent=".$Studentid."";//
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    class Stuinfo{
        public $StuName;
        public $StuPic;
        public $Stumedal;
        public $Stulevel;
        public $StuSchool;
        Public $StuClass;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        //$id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $Stuinfo=new Stuinfo();
            $Stuinfo->StuName=$row["StudentName"];
            $Stuinfo->StuPic=$row["Student_wxPic"];
            $Stuinfo->Stumedal=$row["Studentmedal"];//ѫ�¿����ж��
            $Stuinfo->Stulevel=$row["Studentlevel"];//�ȼ�ֻ��һ��������
            
            $sql1 = "select classname,class_schoolid_FK from class where idclass=".$row["Student_belongto_classid_FK"]."";//
            mysqli_query($link, "set names 'utf8'");
            $result1 = mysqli_query($link, $sql1);
            while($row1 = mysqli_fetch_assoc($result1)) {
                $Stuinfo->StuClass=$row1["classname"];//�༶������
                
                $sql2 = "select Schoolname from School where idSchool=".$row1["class_schoolid_FK"]."";//
                mysqli_query($link, "set names 'utf8'");
                $result2 = mysqli_query($link, $sql2);
                while($row2 = mysqli_fetch_assoc($result2)) {
                    $Stuinfo->StuSchool=$row2["Schoolname"];//ѧУ������
                }
                
            }
            
            $data[] = $Stuinfo;
            
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
