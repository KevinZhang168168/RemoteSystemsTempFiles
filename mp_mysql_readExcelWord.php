
<?php
//��ȡexcel�ļ������ݣ�д��Word���ݿ⣻
//ĿǰWord�����ֻ�У����֣�ƴ�������������ף��ʻ�
//INSERT INTO Word SET Wordcontent='߹',Wordspell='��',WordBushou='��',Wordstrokes='6'

require_once "lib\PHPExcel-1.8\Classes\PHPExcel.php";
include 'lib\PHPExcel-1.8\Classes\PHPExcel\IOFactory.php';

//������
$filename = 'file\Word.xlsx';

$objReader = PHPExcel_IOFactory::createReaderForFile($filename);; //׼�����ļ�

$objPHPExcel = $objReader->load($filename);   //�����ļ�

//ʹ�� PHPExcel_IOFactory �������ļ�Ӧ��ʹ����һ����ȡ�� 
$inputFileType = PHPExcel_IOFactory::identify($filename);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($filename);

$objPHPExcel->setActiveSheetIndex(0);//���õ�һ��Sheet������ѭ����ȡ��ͬ��sheet��ÿ��sheetֻ��һ��ʫ�裬����������excel�ļ��󣬿�������д�������

//д�����ݿ�
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

for ($x=2; $x<=7245; $x++) {
    
    $cell1='A'.$x;
    $cell2='C'.$x;
    $cell3='D'.$x;
    $cell4='E'.$x;
    
    //������һ��������˳�򣬰���˳���ȡ��
    $data1 = $objPHPExcel->getActiveSheet()->getCell($cell1)->getValue();  //��ȡ��Ԫ����
    $data2 = $objPHPExcel->getActiveSheet()->getCell($cell2)->getValue();  //��ȡ��Ԫ��ƴ��������
    $data3 = $objPHPExcel->getActiveSheet()->getCell($cell3)->getValue();  //��ȡ��Ԫ����
    $data4 = $objPHPExcel->getActiveSheet()->getCell($cell4)->getValue();  //��ȡ��Ԫ��ʻ�
    

    if($link){
        //���¼������ֵ��һ�����ȥ��
        $sql_insert = "INSERT INTO Word SET Wordcontent='" .$data1."'" . ",Wordspell='".$data2."'" . ",WordBushou='".$data3."'" . ",Wordstrokes='".$data4."'";
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