<?php

//Kevin Zhang �����������Գɹ���δ����С��������ֻ����ʾ����Ϣ��û���û���ȡ��Ϣ��洢���ݿ�Ĺ��ܣ��������php��ʵ�֡�
//����Ҳ�����������⣬�û���ȡ����Ϣ��δ�����Ѷ��ļ�¼��С���򱾵ص�log�ļ��У���Ҫ����ϴ��������ˣ�
//Ӧ��Ҳ�����û�ÿ�ε�¼���ϴ�����ʾ��һ���˳���ʱ���״̬��
//ÿ���û��˳���ʱ��Ҳ�ϴ�������С����ܶ������ϵͳkill������̵ģ���˲�һ����ִ�б����ϴ�������
//PHP+MySQL���Խ����[ { "id": 1, "idsys_message": "1", "sys_messagename": "ϵͳ��Ϣ1", "sys_messagedetail": "ϵͳ��Ϣ1" }, { "id": 2, "idsys_message": "2", "sys_messagename": "ϵͳ��Ϣ1", "sys_messagedetail": "ϵͳ��Ϣ1" }, { "id": 3, "idsys_message": "3", "sys_messagename": "ϵͳ��Ϣ1", "sys_messagedetail": "ϵͳ��Ϣ1" } ]

//��ҳ�ϳ���3��ϵͳ��Ϣ����������ݿ�����ȡ��ʱ�������3������������ʾ�����

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //echo "db connect success!";
    //$Studentid = $_GET['Studentid'];//��ȡ��С���򴫵ݹ�����idֵ��
    
    //����ϵͳ��Ϣ��ʱ�併������
    $sql = "SELECT idsystem_message,system_messagename,system_messagedetail FROM mp_wx_zxj_demo_mysql.system_message order by system_messagetime DESC limit 0,3";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class sys_message{
        public $id;
        public $idsys_message;
        public $sys_messagename;
        public $sys_messagedetail;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $sys_message=new sys_message();
            $sys_message->id=$id++;
            $sys_message->idsys_message=$row["idsystem_message"];
            $sys_message->sys_messagename=$row["system_messagename"];
            $sys_message->sys_messagedetail=$row["system_messagedetail"];
            $data[] = $sys_message;
            //echo($coursein);
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
