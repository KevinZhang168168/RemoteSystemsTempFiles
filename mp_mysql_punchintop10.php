<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ������С��4��С��2����ȫ2����ȫ6{ "����ȫ": 8, "��С��": 6 } 

//�û����ϴ���Ʒ�����޵��ܴ�������ѧ����������������ݿ�����ȡ������˵����Ʒָ�����û��Լ��ϴ����κ�ý���ļ���������Ƶ���ʶ����Լ��򿨣�
//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

function comm_sumarrs($arr){
    $item = array();
    foreach($arr as $key=>$value){
        
        foreach($value as $k=>$v){
            if(isset($item[$k])){
                $item[$k] = $item[$k] +$v;
            }else{
                $item[$k] = $v;
            }
        }
    }
    //arsort($item);
    return $item;
}

if($link){
    //�����ݿ��в�ѯ��������Ʒ��ÿ����Ʒ�����޵Ĵ�����
    $sql_top10 = "SELECT Student_log_Lid_FK, count(*) FROM Student_log_L group by Student_log_Lid_FK";//Ҫ����
    mysqli_query($link, "set names 'utf8'");
    $result_top10 = mysqli_query($link, $sql_top10);
    class Like_top{
        public $Lid;//�õ�����С��Ƶ��idֵ��
        public $count;//���ֵ��С��Ƶ�����޵Ĵ���
    }
    //�Ѳ�ѯ�������һ��array������һ������
    $data_top10 = array();
    if (mysqli_num_rows($result_top10) > 0) {
        while($row = mysqli_fetch_assoc($result_top10)) {
            $Like_top=new Like_top();
            $Like_top->Lid=$row["Student_log_Lid_FK"];//�õ�С��Ƶ��idֵ����������
            $Like_top->count=$row["count(*)"];//�õ�С��Ƶ�ĵ�������ֵ����������
            $data_top10[] = $Like_top;
        }
    }
    
    class LikestStu{
        //public $idLikestStu;
        public $Stuname;
        public $count;
    };
    
    $data = array();
    if (mysqli_num_rows($result_top10) > 0) {
        $idLikestStu = 1;
        for ($x=0; $x<mysqli_num_rows($result_top10); $x++) {
            //ѭ���ҵ�ÿ�������޵���Ʒ�����ĸ�ѧ����
            $sql = "select StudentName from Student where idStudent=(select Student_shortVideo_log_Stuid_FK from Student_shortVideo_log where idStudent_shortVideo_log = " .$data_top10[$x]->Lid.")";
            mysqli_query($link, "set names 'utf8'");
            $result = mysqli_query($link, $sql);
            //echo($sql);
            
            while($row = mysqli_fetch_assoc($result)) {
                //for ($x1=0; $x1<=count($data); $x1++){
                    $LikestStu=new LikestStu();
                    //$LikestStu->idLikestStu=$idLikestStu++;//����+1
                    //$LikestStu->Stuname=$row["StudentName"];//�õ����ѧ��������
                    $LikestStu->Stuname=$row["StudentName"];//�õ����ѧ����id
                    $LikestStu->count=$data_top10[$x]->count + $LikestStu->count;//�õ����ѧ��id�ĵ�������
                    $data[] = $LikestStu;
                    //echo($LikestStu->Stuname);
                    //echo($LikestStu->count);
                //}
            }
            
        }
        
        //���ǵ�$data[]����洢��ÿ��ѧ���ĵ�������������û����ͣ�������Ҫ��ͣ�
        $res = array();
        /*
        foreach($data as $v) {
            if(isset($datasum[$v['Stuname']])) $datasum[$v['Stuname']]['count'] += $v['count'];
            else $datasum[$v['Stuname']] = $v;
        }
        $datasum = array_values($datasum);
        */
        //$datasum = comm_sumarrs($data);
        //���յ��޵������ϲ�ѧ����
        foreach($data as $v) {
            if(! isset($res[$v->Stuname])) $res[$v->Stuname] = 0;
            $res[$v->Stuname] += $v->count;
        }
        //$res�������ϲ��Ľ�������ڻ���Ҫ����ǰʮ����
        //array_multisort($res,SORT_DESC,$res);
        arsort($res);//���յ��޵�����������
        //ȡǰʮ��
        $res = array_slice($res, 0, 10); 
        //echo($res);
        
        echo json_encode($res,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//��������ת��Ϊjson��ʽ
        
    }
    
    
}
else{
    echo "db connect failed!";
}

?> 