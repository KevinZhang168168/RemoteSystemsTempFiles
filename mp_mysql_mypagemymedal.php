<?php
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "id": 1, "MedalName": "ѫ��1", "Medalpic": null, "levelpic": null }, { "id": 2, "MedalName": "ѫ��2", "Medalpic": null }, { "id": 3, "MedalName": "ѫ��3", "Medalpic": null }, { "id": 4, "MedalName": "ѫ��4", "Medalpic": null }, { "id": 5, "MedalName": "ѫ��5", "Medalpic": null }, { "id": 6, "MedalName": "ѫ��6", "Medalpic": null } ]

//�����ѧ����Ӧ��ѫ����Ϣ�ҳ�������������ݿ�����ȡ��Ȼ������е�ѫ�µ����ƺ�ͼƬҲ�ҳ����������û���ǰ�ĵõ���ѫ�¸���ͼƬ�����˵ĵȼ��ǲ�ɫ�ģ�û�����ǻһ��ģ�
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
    
    $sql = "select Student_medalname,Student_medalpic_HL,Student_medalpic_ashing from Student_medal";//
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    $sql0 = "select Studentmedal from Student where idStudent=".$Studentid."";//
    mysqli_query($link, "set names 'utf8'");
    $result0 = mysqli_query($link, $sql0);
    
    class Medalinfo{
        public $id;
        public $MedalName;
        public $Medalpic;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $Medalinfo=new Medalinfo();
            $Medalinfo->id=$id++;
            $Medalinfo->MedalName=$row["Student_medalname"];
            
            if (mysqli_num_rows($result0) > 0) {
                while($row0 = mysqli_fetch_assoc($result0)) {
                    if (strpos($row0["Studentmedal"],$id)){
                        $Medalinfo->levelpic=$row["Student_medalpic_HL"];
                    }else{
                        $Medalinfo->levelpic=$row["Student_medalpic_ashing"];
                    }
                }
            }
            
            $data[] = $Medalinfo;
            
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
