<?php

//Kevin Zhang �����������Գɹ���δ����С����
//��ʫ���֪ʶ��ը�ĵ������һ��table���ҳ���
//PHP+MySQL���Խ����[ { "Poetryknowname": "֪ʶ��ը֪ʶ��1", "Poetryknownote": "֪ʶ������1", "Poetryknowpic1": null, "Poetryknowpic2": null }, { "Poetryknowname": "֪ʶ��ը֪ʶ��1", "Poetryknownote": "֪ʶ������1", "Poetryknowpic1": null, "Poetryknowpic2": null }, { "Poetryknowname": "֪ʶ��ը֪ʶ��1", "Poetryknownote": "֪ʶ������1", "Poetryknowpic1": null, "Poetryknowpic2": null }, { "Poetryknowname": "֪ʶ��ը֪ʶ��1", "Poetryknownote": "֪ʶ������1", "Poetryknowpic1": null, "Poetryknowpic2": null }, { "Poetryknowname": "֪ʶ��ը֪ʶ��1", "Poetryknownote": "֪ʶ������1", "Poetryknowpic1": null, "Poetryknowpic2": null }, { "Poetryknowname": "֪ʶ��ը֪ʶ��1", "Poetryknownote": "֪ʶ������1", "Poetryknowpic1": null, "Poetryknowpic2": null }, { "Poetryknowname": "֪ʶ��ը֪ʶ��1", "Poetryknownote": "֪ʶ������1", "Poetryknowpic1": null, "Poetryknowpic2": null } ]

//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//��ȡһ��ʫ�����Ƶ����
if($link){
    //idPoetry = $_GET['idPoetry'];//��ȡ��С���򴫵ݹ�����idֵ��
    
    //idPoetry=1��ʱ����1���棬ʵ��΢��С������idPoetry
    $idPoetry=1;
    $sql = "SELECT Poetry_knowledgename,Poetry_knowledgenote,Poetry_knowledgepic1,Poetry_knowledgepic2 FROM Poetry_knowledge where Poetry_knowledgeid_FK=".$idPoetry."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class poetryknowledge{
        public $Poetryknowname;
        public $Poetryknownote;
        public $Poetryknowpic1;
        public $Poetryknowpic2;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $poetryknowledge=new poetryknowledge();
            $poetryknowledge->Poetryknowname=$row["Poetry_knowledgename"];
            $poetryknowledge->Poetryknownote=$row["Poetry_knowledgenote"];
            $poetryknowledge->Poetryknowpic1=$row["Poetry_knowledgepic1"];
            $poetryknowledge->Poetryknowpic2=$row["Poetry_knowledgepic2"];
            $data[] = $poetryknowledge;
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