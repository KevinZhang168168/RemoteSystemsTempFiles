<?php
header("Content-Type:text/html;charset=UTF-8");
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "id": 1, "idPunckin": "", "Punckindate": "" }, { "id": 2, "idPunckin": "", "Punckindate": "" }, { "id": 3, "idPunckin": "", "Punckindate": "" }, { "id": 4, "idPunckin": "", "Punckindate": "" }, { "id": 5, "idPunckin": "", "Punckindate": "" }, { "id": 6, "idPunckin": "", "Punckindate": "" }, { "id": 7, "idPunckin": "", "Punckindate": "" }, { "id": 8, "idPunckin": "", "Punckindate": "" }, { "id": 9, "idPunckin": "", "Punckindate": "" }, { "id": 10, "idPunckin": "", "Punckindate": "" }, { "id": 11, "idPunckin": "", "Punckindate": "" }, { "id": 12, "idPunckin": "", "Punckindate": "" }, { "id": 13, "idPunckin": "", "Punckindate": "" }, { "id": 14, "idPunckin": "", "Punckindate": "" }, { "id": 15, "idPunckin": "1", "Punckindate": "2018-09-15 00:00:00" }, { "id": 16, "idPunckin": "2", "Punckindate": "2018-09-16 00:00:00" }, { "id": 17, "idPunckin": "3", "Punckindate": "2018-09-17 00:00:00" }, { "id": 18, "idPunckin": "4", "Punckindate": "2018-09-18 00:00:00" }, { "id": 19, "idPunckin": "5", "Punckindate": "2018-09-19 00:00:00" }, { "id": 20, "idPunckin": "6", "Punckindate": "2018-09-20 00:00:00" }, { "id": 21, "idPunckin": "7", "Punckindate": "2018-09-21 00:00:00" }, { "id": 22, "idPunckin": "8", "Punckindate": "2018-09-22 00:00:00" }, { "id": 23, "idPunckin": "9", "Punckindate": "2018-09-23 00:00:00" }, { "id": 24, "idPunckin": "10", "Punckindate": "2018-09-24 00:00:00" }, { "id": 25, "idPunckin": "", "Punckindate": "" }, { "id": 26, "idPunckin": "", "Punckindate": "" }, { "id": 27, "idPunckin": "", "Punckindate": "" }, { "id": 28, "idPunckin": "", "Punckindate": "" }, { "id": 29, "idPunckin": "", "Punckindate": "" }, { "id": 30, "idPunckin": "", "Punckindate": "" } ]


//�����Ҫ��С����ҳ�������ص�ֵ����������Ҫ��punckin����ȡ��ÿ����Ҫ�򿨵�ʫ���id������ȡ���ѧ��ÿ��򿨵ļ�¼�����Աȣ�����֪��������������ɫ��עview��
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);


if($link){
    //$dateYMD = $_GET['dateYMD'];//��ȡ��С���򴫵ݹ�����ʱ��ֵ��
    //$idStu = $_GET['idStu'];//��ȡ��С���򴫵ݹ���ѧ��id
    $dateYMD = '2018-09-21';
    $idStu = '1';
    
    //�Ȱ��մ��ݽ��������ڣ���Punchin����У��������·ݵ�Ӧ����Ϣȫ���ҳ��������մ�1����31�ŵ�˳��
    //Ҳ�п��ܲ��������µģ���Ϊ�������ǵĴ������Ǵ�ĳ���·ݵ��м�һ�����ڿ�ʼ�ģ���֮�����²��ң�
    //echo($dateYMD);
    //echo(strtotime($dateYMD));
    //echo(date("Y",strtotime($dateYMD)));
    $sql = "select idPunchin,PunchinPoetryid_FK,PunchinExreadingid_FK,Punchindate from Punchin where Year(Punchindate)='".date("Y",strtotime($dateYMD))."' and Month(Punchindate)='".date("m",strtotime($dateYMD))."' order by Punchindate asc";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    //echo($sql);
    
    class PunchinList{
        public $id;//�������һ��id��˳��ֵ��
        public $idPunckin;//�������id������˳���ţ������޴����񣬸�ֵΪ�գ�
        public $Punckindate;//ѧ���򿨵����ڣ����ֵ��ѧ���򿨵����ڣ����Ǵ���������ڣ�������ѧ�����򿨵����ڣ�Ҳ�����ǿգ���ʾѧ������û�д򿨣�
    }
    
    //$id = 1;
    $data = array();
    if (mysqli_num_rows($result) > 0) {//�����������0��֤�������д�����
        
        
        
        //��Ҫ�и����ѭ����ѭ�������£���Ϊû�д����������Ҳ��Ҫ����ֵ������ȫ�¶�û�д�����
        $monthdate = date("t",strtotime($dateYMD));//ָ���·�Ӧ�е�������
        $arr=getdate(strtotime($dateYMD));//ʹ��getdate()��������ǰ��Ϣ���档
       
        for ($x=1; $x<=$monthdate; $x++) {//ѭ������
            //echo($x);
            $PunchinList=new PunchinList();
            $PunchinList->id=$x;
            
            //�ӱ��µĵ�һ�쿪ʼѭ������;���������Ƿ��д�����
            $sql2 = "select idPunchin,PunchinPoetryid_FK,PunchinExreadingid_FK,Punchindate from Punchin where Punchindate='".$arr["year"]."-".$arr["mon"]."-".$x." '";
            mysqli_query($link, "set names 'utf8'");
            $result2 = mysqli_query($link, $sql2);
            
            if (mysqli_num_rows($result2) > 0){
                //�����Ϊ0����ʾ�����д�����
                while($row2 = mysqli_fetch_assoc($result2)) {
                    
                    
                    //�����ѧ���Ĵ���Ϣ��������ұ��µĴ򿨼�¼��������ѧ����ĳ���������id����֤���������������������񣻵��ǲ������ǵ����ģ�
                    //�����Ǻ������ģ�
                    $sql1 = "select Student_log_Punchindate,Student_log_Punchinid_FK from Student_log_Punchin where Student_log_PunchinidStu_FK=".$idStu." and Student_log_Punchinid_FK=".$row2["idPunchin"];
                    mysqli_query($link, "set names 'utf8'");
                    $result1 = mysqli_query($link, $sql1);
                    if (mysqli_num_rows($result1) > 0) {//��������¼
                        $row1 = mysqli_fetch_assoc($result1);
                        $PunchinList->idPunckin=$row1["Student_log_Punchinid_FK"];
                        $PunchinList->Punckindate=$row1["Student_log_Punchindate"];
                    }else{//û��������¼,��ֵΪidPunchinΪ�������id������Ϊ�գ�
                        $PunchinList->idPunckin=$row2["idPunchin"];
                        $PunchinList->Punckindate="";
                    }
                }
            }else{
                //���Ϊ0����ʾ�����޴����񣻶��ǿ�ֵ��
                $PunchinList->idPunckin="";
                $PunchinList->Punckindate="";
            }
            
            //echo($PunchinList->id);
            //echo($PunchinList->idPunckin);
            //echo($PunchinList->Punckindate);
            $data[] = $PunchinList;
        }
        
        
    }else{//����֤��ȫ�¶�û�д����񣬿���ֱ���˳������С�������õ���ֵ��ȫ�գ����ʾȫ��û�д�����
        return 0;
        exit;
            
    }
    
    //��Ӧ����һ��ѧϰ���ȵ�Json���ݷ��أ��������ĵ���д�ϣ������php�л�û��ʵ�֡�
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//��������ת��Ϊjson��ʽ
    //echo json_encode($data);
    //echo sizeof($data);
        
}
    

else{
    echo "db connect failed!";
}

?>
