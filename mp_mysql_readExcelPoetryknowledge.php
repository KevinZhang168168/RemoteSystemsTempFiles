<?php
//��ȡexcel�ļ������ݣ�ֻ��ȡ֪ʶ��ը����Ϣ���ص���ͼƬ�Ķ�ȡ��������������С��ʿ���͡����û���������������ʦ�õ����ݣ���������php��д�룻
//Ҳ������ʫ������岿��
//

require_once "lib\PHPExcel-1.8\Classes\PHPExcel.php";
include 'lib\PHPExcel-1.8\Classes\PHPExcel\IOFactory.php';

function strcomp($str1,$str2){
    if($str1 == $str2){
        return TRUE;
    }else{
        return FALSE;
    }
} 

//������

$filename = 'file\Poetry.xlsx';

$objReader = PHPExcel_IOFactory::createReaderForFile($filename);; //׼�����ļ�

$objPHPExcel = $objReader->load($filename);   //�����ļ�

//$objPHPExcel->setActiveSheetIndex(0);         //���õ�һ��Sheet������ֻ��ȡ�˵�һ��sheet���Ժ�ÿ��ʫ�趼���������sheet�Ϳ����ˣ�������ͬ��˳��

//������һ��������˳�򣬰���˳���ȡ��
$data1 = $objPHPExcel->getActiveSheet()->getCell('B5')->getValue();  //��ȡ��Ԫ��B5��ֵ��ʫ������

//д�����ݿ�
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//ѭ���˴Σ���0��ʼ������8��sheet
for ($x1=0; $x1<=7; $x1++) {
    $objPHPExcel->setActiveSheetIndex($x1); //���õ�һ��Sheet������ѭ����ȡ��ͬ��sheet��ÿ��sheetֻ��һ��ʫ�裬����������excel�ļ��󣬿�������д�������
    
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
    
    ////////////////////////////////////����һ���԰�Excel�ļ����ͼƬ����������
    $i = 0;
    $ai = 0;
    foreach ($objPHPExcel->getActiveSheet()->getDrawingCollection() as $drawing) {
        if ($drawing instanceof PHPExcel_Worksheet_MemoryDrawing) {
            ob_start();
            call_user_func(
                $drawing->getRenderingFunction(),
                $drawing->getImageResource()
                );
            $imageContents = ob_get_contents();
            ob_end_clean();
            switch ($drawing->getMimeType()) {
                case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_PNG :
                    $extension = 'png'; break;
                case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_GIF:
                    $extension = 'gif'; break;
                case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_JPEG :
                    $extension = 'jpg'; break;
            }
            echo($extension);
        } else {
            $zipReader = fopen($drawing->getPath(),'r');
            $imageContents = '';
            while (!feof($zipReader)) {
                $imageContents .= fread($zipReader,1024);
            }
            fclose($zipReader);
            $extension = $drawing->getExtension();
        }
        
        //���ǰ����е�ͼƬ��������һ����ʱĿ¼�£�
        $myFileName = 'file\tempimage\00_Image_'.++$i.'.'.$extension;
        file_put_contents($myFileName,$imageContents);
        
        $codata[][] = array();
        $codatacell[] = array();
        $codatacell[0] = $drawing->getCoordinates(); //�õ���Ԫ���� ����D13��Ԫ��
        $codatacell[1] = $myFileName;//�õ���Ӧ���ļ����ƣ�
        $codata[$ai] = $codatacell;
        $ai++;
        //echo($ai);
        //echo($codatacell[0]);
        //echo($codatacell[1]);
        //var_dump($codata[$ai]);
        //echo($codata[0][0]);
        //$ai++;
    }
    //////////////////////////////////
    
    //�ӵ�13�п�ʼ������21�н�����һ��9����֪ʶ��ը��
    for ($x=13; $x<=21; $x++) {
        $cellnumber1 = 'B'.$x;
        $cellnumber2 = 'C'.$x;
        $cellnumber3 = 'D'.$x;
        $cellnumber4 = 'E'.$x;
        
        $data2 = $objPHPExcel->getActiveSheet()->getCell($cellnumber1)->getValue();  //��ȡ��Ԫ��B13��ֵ��֪ʶ��ը֪ʶ��1������
        if(is_null($data2)){
            break;//���Ϊ�գ���ʾ���������ݣ�
        }
        $data21 = $objPHPExcel->getActiveSheet()->getCell($cellnumber2)->getValue();  //��ȡ��Ԫ��C13��ֵ��֪ʶ��ը֪ʶ��1������
        //$data22 = $objPHPExcel->getActiveSheet()->getCell($cellnumber3)->getValue();  //��ȡ��Ԫ��D13��ֵ��֪ʶ��ը֪ʶ��1�ĵ�һ��ͼƬ
        //$data23 = $objPHPExcel->getActiveSheet()->getCell($cellnumber4)->getValue();  //��ȡ��Ԫ��E13��ֵ��֪ʶ��ը֪ʶ��1�ĵڶ���ͼƬ
        
        //�Ȱ����ֲ���
        $sql_insert1 = "INSERT INTO Poetry_knowledge SET Poetry_knowledgeid_FK=" .$poetryid."" . ",Poetry_knowledgename='".$data2."'" . ",Poetry_knowledgenote='".$data21."'";
        mysqli_query($link, "set names 'utf8'");
        $result_insert1 = mysqli_query($link, $sql_insert1);
        //echo ($result_insert1);
        $query = "select max(idPoetry_knowledge) from mp_wx_zxj_demo_mysql.poetry_knowledge";
        mysqli_query($link, "set names 'utf8'");
        $res = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($res);
        //echo($row);
        
        
        //����õ���ЩͼƬ�����Ǵ��ĸ���Ԫ���ж�ȡ�ģ�
        $ic=0;
        for ($ic=0; $ic<count($codata); $ic++) {
            //$codata = $drawing->getCoordinates(); //�õ���Ԫ���� ����D13��Ԫ
            //echo($codata);
            
            //$codatacell=$codata[$ic];
            //����ȷ��D�з����һ��ͼƬ��
            if(strcomp($codata[$ic][0],$cellnumber3)){
                //���¼������ֵ��һ�����ȥ��
                $PSize = filesize($codata[$ic][1]);
                $mysqlPicture = addslashes(fread(fopen($codata[$ic][1], "r"), $PSize));
                //echo($codata[$ic][0]);
                //echo($cellnumber3);
                
                $sql_insert = "UPDATE Poetry_knowledge SET Poetry_knowledgepic1='".$mysqlPicture."'"." where idPoetry_knowledge=".$row["max(idPoetry_knowledge)"]."";//. ",Poetry_knowledgepic2='".$data23."'";
                mysqli_query($link, "set names 'utf8'");
                $result_insert = mysqli_query($link, $sql_insert);
                
                //echo( $sql_insert);
            }
            
            //����ȷ��E�з���ڶ���ͼƬ
            
            if(strcomp($codata[$ic][0],$cellnumber4)){
                //���¼������ֵ��һ�����ȥ��
                $PSize = filesize($codata[$ic][1]);
                $mysqlPicture = addslashes(fread(fopen($codata[$ic][1], "r"), $PSize));
                //echo($codata);
                
                $sql_insert = "UPDATE Poetry_knowledge SET Poetry_knowledgepic2='".$mysqlPicture."'"." where idPoetry_knowledge=".$row["max(idPoetry_knowledge)"]."";
                mysqli_query($link, "set names 'utf8'");
                $result_insert = mysqli_query($link, $sql_insert);
                
                //echo( $sql_insert);
            }
            
        }
        //$ic++;
    }
//////////////////
}


/*
$data3 = $objPHPExcel->getActiveSheet()->getCell('B14')->getValue();  //��ȡ��Ԫ��B13��ֵ��֪ʶ��ը֪ʶ��1
$data4 = $objPHPExcel->getActiveSheet()->getCell('B15')->getValue();  //��ȡ��Ԫ��B13��ֵ��֪ʶ��ը֪ʶ��1
$data5 = $objPHPExcel->getActiveSheet()->getCell('B16')->getValue();  //��ȡ��Ԫ��B13��ֵ��֪ʶ��ը֪ʶ��1
$data6 = $objPHPExcel->getActiveSheet()->getCell('B17')->getValue();  //��ȡ��Ԫ��B13��ֵ��֪ʶ��ը֪ʶ��1
$data7 = $objPHPExcel->getActiveSheet()->getCell('B18')->getValue();  //��ȡ��Ԫ��B13��ֵ��֪ʶ��ը֪ʶ��1
$data8 = $objPHPExcel->getActiveSheet()->getCell('B19')->getValue();  //��ȡ��Ԫ��B13��ֵ��֪ʶ��ը֪ʶ��1
$data9 = $objPHPExcel->getActiveSheet()->getCell('B20')->getValue();  //��ȡ��Ԫ��B13��ֵ��֪ʶ��ը֪ʶ��1
$data10 = $objPHPExcel->getActiveSheet()->getCell('B21')->getValue();  //��ȡ��Ԫ��B13��ֵ��֪ʶ��ը֪ʶ��1
*/

if($link){
    /*
    $imgData=array();
    $imageFilePath='/images/'.date('Y/m/d').'/';//ͼƬ����Ŀ¼
    foreach($sheet->getDrawingCollection() as $img){
        list ($startColumn, $startRow) = PHPExcel_Cell::coordinateFromString($img->getCoordinates());//��ȡ�����к�
        $imageFileName=$img->getCoordinates().mt_rand(100,999);
    //��������ͼƬ������Դ��ʽ�����ڶ����У�����ͨ��getImageResource����ֱ�ӻ�ȡͼƬ��ԴȻ��д�뱾���ļ���
    switch ($img->getMimeType()){//����ͼƬ��ʽ
        case 'image/jpg':
        case 'image/jpeg':
            $imageFileName.='.jpg';
            imagejpeg($img->getImageResource(),$imageFilePath.$imageFileName);
            break;
        case 'image/gif':
            $imageFileName.='.gif';
            imagegif($img->getImageResource(),$imageFilePath.$imageFileName);
            break;
        case 'image/png':
            $imageFileName.='.png';
            imagepng($img->getImageResource(),$imageFilePath.$imageFileName);
            break;
    }
    }*/
    
    //����������У���ô��������ڴ�D13�����ȡ���ǿյģ������ҵ�
    /*
    $Picture='file\test.png';
    If($Picture != "none") {
        $PSize = filesize($Picture);
        $mysqlPicture = addslashes(fread(fopen($Picture, "r"), $PSize));
        //mysql_connect($host,$username,$password2003) or die("Unable to connect to SQL server");
        //@mysql_select_db($db) or die("Unable to select database");
        //mysql_query("INSERT INTO Images (Image) VALUES ($mysqlPicture)") or die("Cant Perform Query");
        $sql_insert = "INSERT INTO Poetry_knowledge SET Poetry_knowledgeid_FK='" .$poetryid."'" . ",Poetry_knowledgename='".$data2."'" . ",Poetry_knowledgenote='".$data21."'". ",Poetry_knowledgepic1='".$mysqlPicture."'". ",Poetry_knowledgepic2='".$data23."'";
        mysqli_query($link, "set names 'utf8'");
        $result_insert = mysqli_query($link, $sql_insert);
    }else {
        echo"You did not upload any picture";
    }   
    */
    //echo($imageContents);
    
    //���¼������ֵ��һ�����ȥ��
    //$sql_insert = "INSERT INTO Poetry_knowledge SET Poetry_knowledgeid_FK=" .$poetryid."" . ",Poetry_knowledgename='".$data2."'" . ",Poetry_knowledgenote='".$data21."'". ",Poetry_knowledgepic1='".$imageContents."'";//. ",Poetry_knowledgepic2='".$data23."'";
    //mysqli_query($link, "set names 'utf8'");
    //$result_insert = mysqli_query($link, $sql_insert);
    
    //$data[] = $media_top3service;
    //echo( $sql_insert);
    
}
else{
    echo "db connect failed!";
}


//echo $data;

 

//д����

//$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Hello');//ָ��Ҫд�ĵ�Ԫ��λ�� 

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

//$objWriter->save('2.xls');

 

?>