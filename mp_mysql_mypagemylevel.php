<?php
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "id": 1, "levelName": "��ͯ", "levelpic": null }, { "id": 2, "levelName": "��������", "levelpic": null }, { "id": 3, "levelName": "���", "levelpic": null }, { "id": 4, "levelName": "����", "levelpic": null }, { "id": 5, "levelName": "��ʿ", "levelpic": null }, { "id": 6, "levelName": "̽��", "levelpic": null }, { "id": 7, "levelName": "����", "levelpic": null }, { "id": 8, "levelName": "״Ԫ", "levelpic": null } ]

//�����ѧ����Ӧ�ĵȼ���Ϣ�ҳ�������������ݿ�����ȡ��Ȼ������еĵȼ������ƺ�ͼƬҲ�ҳ����������û���ǰ�ĵȼ�����ͼƬ�����˵ĵȼ��ǲ�ɫ�ģ�û�����ǻһ��ģ�
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
    
    $sql = "select Student_levelname,Student_levelpic_HL,Student_levelpic_ashing from Student_level";//
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    $sql0 = "select Studentlevel from Student where idStudent=".$Studentid."";//
    mysqli_query($link, "set names 'utf8'");
    $result0 = mysqli_query($link, $sql0);
    
    class Levelinfo{
        public $id;
        public $levelName;
        public $levelpic;
        
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $Levelinfo=new Levelinfo();
            $Levelinfo->id=$id++;
            $Levelinfo->levelName=$row["Student_levelname"];
            
            if (mysqli_num_rows($result0) > 0) {
                while($row0 = mysqli_fetch_assoc($result0)) {
                    if ($row0["Studentlevel"]>=$id){
                        $Levelinfo->levelpic=$row["Student_levelpic_HL"];
                    }else{
                        $Levelinfo->levelpic=$row["Student_levelpic_ashing"];
                    }
                }
            }   
            
            $data[] = $Levelinfo;
            
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
