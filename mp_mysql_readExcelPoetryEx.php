<?php
//��ȡexcel�ļ������ݣ�д��Poetry����ʫ����չ�Ķ���������������С��ʿ���͡����û���������������ʦ�õ����ݣ���������php��д�룻
//Ҳ������֪ʶ��ը���ڱ��php��д�����ݿ�
//INSERT INTO Poetry_extended_reading SET Poetry_extended_readingPoetryid_FK=3,Poetry_extended_readingname='���� ',Poetry_extended_readingdynasty='��',Poetry_extended_readingauthor='�߶�',Poetry_extended_readingcentent='һҶ������߳���ɫ΢�� ˮ�����μ����������Ƿɡ� ����δ���������������� ������Զ����Ī�ʼ�ʱ�顣',Poetry_extended_readingnote=''INSERT INTO Poetry_extended_reading SET Poetry_extended_readingPoetryid_FK=3,Poetry_extended_readingname='���� ',Poetry_extended_readingdynasty='��',Poetry_extended_readingauthor='����',Poetry_extended_readingcentent='ҹ��������̿գ��������������硣 ��ϡ�����ſ������ֱ��紵����С� ',Poetry_extended_readingnote='ʫ�ʴ��⣺��ҹ��Ӹ߿��д�������,���ɷ��������򵥵�����.������ģ��������ǿ������,�������������һ��������'

require_once "lib\PHPExcel-1.8\Classes\PHPExcel.php";

//������
$filename = 'file\Poetry.xlsx';

$objReader = PHPExcel_IOFactory::createReaderForFile($filename);; //׼�����ļ�

$objPHPExcel = $objReader->load($filename);   //�����ļ�

//$objPHPExcel->setActiveSheetIndex(0);         //���õ�һ��Sheet������ֻ��ȡ�˵�һ��sheet���Ժ�ÿ��ʫ�趼���������sheet�Ϳ����ˣ�������ͬ��˳��

//������һ��������˳�򣬰���˳���ȡ����ȡ��һ����չ�Ķ�
$data1 = $objPHPExcel->getActiveSheet()->getCell('B5')->getValue();  //��ȡ��Ԫ��B5��ֵ��ʫ������

//д�����ݿ�
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);
if($link){
    //����ʫ��������ҵ���Ӧ��id����Ϊ�������ݿ��������ˣ�
    $sql = "select idPoetry from Poetry where PoetryName='".$data1."'";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    $poetryid="";
    
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $poetryid=$row["idPoetry"];
        }
    }
}
else{
    echo "db connect failed!";
}

//ѭ���˴Σ���0��ʼ������8��sheet
for ($x=0; $x<=7; $x++) {
    $objPHPExcel->setActiveSheetIndex($x); //���õ�һ��Sheet������ѭ����ȡ��ͬ��sheet��ÿ��sheetֻ��һ��ʫ�裬����������excel�ļ��󣬿�������д�������
    
    $data2 = $objPHPExcel->getActiveSheet()->getCell('B22')->getValue();  //��ȡ��Ԫ����չ�Ķ�1������
    $data3 = $objPHPExcel->getActiveSheet()->getCell('C22')->getValue();  //��ȡ��Ԫ����չ�Ķ�1�ĳ���
    $data4 = $objPHPExcel->getActiveSheet()->getCell('D22')->getValue();  //��ȡ��Ԫ����չ�Ķ�1������
    $data5 = $objPHPExcel->getActiveSheet()->getCell('E22')->getValue();  //��ȡ��Ԫ����չ�Ķ�1������
    $data51 = $objPHPExcel->getActiveSheet()->getCell('F22')->getValue();  //��ȡ��Ԫ����չ�Ķ�1��ʫ�ʴ���
    
    
    if($link){
        //echo($imageContents);
        
        //���¼������ֵ��һ�����ȥ��
        $sql_insert = "INSERT INTO Poetry_extended_reading SET Poetry_extended_readingPoetryid_FK=" .$poetryid."" . ",Poetry_extended_readingname='".$data2."'" . ",Poetry_extended_readingdynasty='".$data3."'". ",Poetry_extended_readingauthor='".$data4."'". ",Poetry_extended_readingcentent='".$data5."'". ",Poetry_extended_readingnote='".$data51."'";
        mysqli_query($link, "set names 'utf8'");
        $result_insert = mysqli_query($link, $sql_insert);
        
        //$data[] = $media_top3service;
        echo( $sql_insert);
        
    }
    else{
        echo "db connect failed!";
    }
    
    
    //������һ��������˳�򣬰���˳���ȡ����ȡ�ڶ�����չ�Ķ�
    $data6 = $objPHPExcel->getActiveSheet()->getCell('B23')->getValue();  //��ȡ��Ԫ����չ�Ķ�2������
    $data7 = $objPHPExcel->getActiveSheet()->getCell('C23')->getValue();  //��ȡ��Ԫ����չ�Ķ�2�ĳ���
    $data8 = $objPHPExcel->getActiveSheet()->getCell('D23')->getValue();  //��ȡ��Ԫ����չ�Ķ�2������
    $data9 = $objPHPExcel->getActiveSheet()->getCell('E23')->getValue();  //��ȡ��Ԫ����չ�Ķ�2������
    $data91 = $objPHPExcel->getActiveSheet()->getCell('F23')->getValue();  //��ȡ��Ԫ����չ�Ķ�2��ʫ�ʴ���
    
    if($link){
        //���¼������ֵ��һ�����ȥ��
        $sql_insert = "INSERT INTO Poetry_extended_reading SET Poetry_extended_readingPoetryid_FK=" .$poetryid."" . ",Poetry_extended_readingname='".$data6."'" . ",Poetry_extended_readingdynasty='".$data7."'". ",Poetry_extended_readingauthor='".$data8."'". ",Poetry_extended_readingcentent='".$data9."'". ",Poetry_extended_readingnote='".$data91."'";
        mysqli_query($link, "set names 'utf8'");
        $result_insert = mysqli_query($link, $sql_insert);
        
        echo( $sql_insert);
        
    }
    else{
        echo "db connect failed!";
    }
}


//д����

//$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Hello');//ָ��Ҫд�ĵ�Ԫ��λ��

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

//$objWriter->save('2.xls');



?>