
<?php
//��ȡexcel�ļ������ݣ�д��Poetry���ݿ⣻������д��Poetry���ⲿ�֣�������������С��ʿ���͡����û���������������ʦ�õ����ݣ���������php��д�룻
//Ҳ������֪ʶ��ը���ڱ��php��д�����ݿ�
//INSERT INTO Poetry SET PoetryName='���',idPoetryAuthorDynasty_FK='��',idPoetryAuthor_FK='�߶�',PoetryContent='�ݳ�ݺ�ɶ����죬�����������̡� ��ͯɢѧ�����磬æ�ö����ֽ𰡣',PoetryAuthorNote='�߶����������ʫ�ˡ�����һ������׾�ᣬ�ʺͣ����㽭ʡ�����У��ˡ��߶�������ѻƬս��֮�󣬴�Լ���̷���䣨1851��1861���������С�׾��ʫ�塷�ȡ�',PoetryZonglan='����ӡ������ʫ�˸߶�������һ�����Ծ��䡣ǰ����д���������˽��϶������ĵġ�����ͼ����������д�ˣ��̻��˶�ͯ��ѧ�����ŷ��ݵġ��ִ�ͼ�������˺�һ����ӳ��Ȥ����������ľ������²������ˣ��ĸ���Ȥ���£�չ���˴������������ľ����㷢�����߶Դ������ٵ�ϲ�ú�������',PoetryFJSY='�ݳ�ݺ�ɶ����죬�����������̡�������ʫд���Ǵ�������֮���� �ݳ�ݺ�ɶ����죺�紺���£�С����ѿ��������������ɵ���������ݺ������������裬��������С� �����������̣�������������Ҷ�������ϸ����֦���ڴ�����ҡ�ڣ�����ط�ɨ�ŵ̰��� ��ͯɢѧ�����磬æ�ö����ֽ𰡣������д���Ǵ�������֮�ˡ� ��ͯɢѧ�����磺��������С�����Ƿ�ѧ������ػ����ˡ� æ�ö����ֽ𰣺���������������Ĵ���ŷ����أ�',PoetrySFDB='1.���ݳ�ݺ�ɡ��ĸ��֣����ж��У�ӿ���Ŵ��������� 2.�������������֣������˵��ַ���д���������Ľ��ˡ���̬�����ϡ� 3.ʫ�����Ｐ�ˣ����������˵Ĵ������������õĺ�ͯ�໥��Ⱦ���໥ӳ�ģ����������ֳ���ϣ���Ĵ��쾡����ǰ��'

require_once "lib\PHPExcel-1.8\Classes\PHPExcel.php";

//������

$filename = 'file\Poetry.xlsx';

$objReader = PHPExcel_IOFactory::createReaderForFile($filename);; //׼�����ļ�

$objPHPExcel = $objReader->load($filename);   //�����ļ�

//д�����ݿ�
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//ѭ���˴Σ���0��ʼ������8��sheet
for ($x=0; $x<=7; $x++) {
    $objPHPExcel->setActiveSheetIndex($x); //���õ�һ��Sheet������ѭ����ȡ��ͬ��sheet��ÿ��sheetֻ��һ��ʫ�裬����������excel�ļ��󣬿�������д�������

    //������һ��������˳�򣬰���˳���ȡ��
    $data1 = $objPHPExcel->getActiveSheet()->getCell('B5')->getValue();  //��ȡ��Ԫ��B5��ֵ��ʫ������
    $data2 = $objPHPExcel->getActiveSheet()->getCell('B6')->getValue();  //��ȡ��Ԫ��B6��ֵ��ʫ�賯��
    $data3 = $objPHPExcel->getActiveSheet()->getCell('B7')->getValue();  //��ȡ��Ԫ��B7��ֵ��ʫ������
    $data4 = $objPHPExcel->getActiveSheet()->getCell('B8')->getValue();  //��ȡ��Ԫ��B8��ֵ��ʫ������
    $data5 = $objPHPExcel->getActiveSheet()->getCell('B9')->getValue();  //��ȡ��Ԫ��B9��ֵ��ʫ��ʫ�˼��
    $data6 = $objPHPExcel->getActiveSheet()->getCell('B10')->getValue();  //��ȡ��Ԫ��B10��ֵ��ʫ������
    $data7 = $objPHPExcel->getActiveSheet()->getCell('B11')->getValue();  //��ȡ��Ԫ��B11��ֵ��ʫ��־�����
    $data8 = $objPHPExcel->getActiveSheet()->getCell('B12')->getValue();  //��ȡ��Ԫ��B12��ֵ��ʫ���ַ��㲦

    if($link){
        //���¼������ֵ��һ�����ȥ��
        $sql_insert = "INSERT INTO Poetry SET PoetryName='" .$data1."'" . ",idPoetryAuthorDynasty_FK='".$data2."'" . ",idPoetryAuthor_FK='".$data3."'" . ",PoetryContent='".$data4."'" . ",PoetryAuthorNote='".$data5."'". ",PoetryZonglan='".$data6."'". ",PoetryFJSY='".$data7."'". ",PoetrySFDB='".$data8."'";
        mysqli_query($link, "set names 'utf8'");
        $result_insert = mysqli_query($link, $sql_insert);
    
        //$data[] = $media_top3service;
        echo( $sql_insert);
    
        //echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//��������ת��Ϊjson��ʽ
        //echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//��������ת��Ϊjson��ʽ
        //echo json_encode($data);
        //echo sizeof($data);
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