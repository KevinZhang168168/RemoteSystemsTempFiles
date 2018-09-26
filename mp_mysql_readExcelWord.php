
<?php
//读取excel文件的数据，写入Word数据库；
//目前Word表格中只有：汉字，拼音带音调，部首，笔画
//INSERT INTO Word SET Wordcontent='吖',Wordspell='ā',WordBushou='口',Wordstrokes='6'

require_once "lib\PHPExcel-1.8\Classes\PHPExcel.php";
include 'lib\PHPExcel-1.8\Classes\PHPExcel\IOFactory.php';

//读数据
$filename = 'file\Word.xlsx';

$objReader = PHPExcel_IOFactory::createReaderForFile($filename);; //准备打开文件

$objPHPExcel = $objReader->load($filename);   //载入文件

//使用 PHPExcel_IOFactory 来鉴别文件应该使用哪一个读取类 
$inputFileType = PHPExcel_IOFactory::identify($filename);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($filename);

$objPHPExcel->setActiveSheetIndex(0);//设置第一个Sheet，后面循环读取不同的sheet，每个sheet只有一首诗歌，后面做好了excel文件后，可以重新写这个部分

//写入数据库
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

for ($x=2; $x<=7245; $x++) {
    
    $cell1='A'.$x;
    $cell2='C'.$x;
    $cell3='D'.$x;
    $cell4='E'.$x;
    
    //以下是一个基本的顺序，按照顺序读取；
    $data1 = $objPHPExcel->getActiveSheet()->getCell($cell1)->getValue();  //获取单元格汉字
    $data2 = $objPHPExcel->getActiveSheet()->getCell($cell2)->getValue();  //获取单元格拼音带音调
    $data3 = $objPHPExcel->getActiveSheet()->getCell($cell3)->getValue();  //获取单元格部首
    $data4 = $objPHPExcel->getActiveSheet()->getCell($cell4)->getValue();  //获取单元格笔画
    

    if($link){
        //把新计算的数值逐一插入进去；
        $sql_insert = "INSERT INTO Word SET Wordcontent='" .$data1."'" . ",Wordspell='".$data2."'" . ",WordBushou='".$data3."'" . ",Wordstrokes='".$data4."'";
        mysqli_query($link, "set names 'utf8'");
        $result_insert = mysqli_query($link, $sql_insert);
    
        echo( $sql_insert);
    }
    else{
        echo "db connect failed!";
    }

}
//写数据

//$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Hello');//指定要写的单元格位置 

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

//$objWriter->save('2.xls');
?>