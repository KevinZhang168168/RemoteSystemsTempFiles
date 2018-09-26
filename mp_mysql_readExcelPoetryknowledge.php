<?php
//读取excel文件的数据，只读取知识大爆炸的信息，重点是图片的读取，不包括“问题小贴士”和“课堂互动”这两部分老师用的内容；在其他的php里写入；
//也不包括诗歌的主体部分
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

//读数据

$filename = 'file\Poetry.xlsx';

$objReader = PHPExcel_IOFactory::createReaderForFile($filename);; //准备打开文件

$objPHPExcel = $objReader->load($filename);   //载入文件

//$objPHPExcel->setActiveSheetIndex(0);         //设置第一个Sheet，这里只读取了第一个sheet，以后每首诗歌都放入独立的sheet就可以了，按照相同的顺序；

//以下是一个基本的顺序，按照顺序读取；
$data1 = $objPHPExcel->getActiveSheet()->getCell('B5')->getValue();  //获取单元格B5的值，诗歌名字

//写入数据库
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//循环八次，从0开始，代表8个sheet
for ($x1=0; $x1<=7; $x1++) {
    $objPHPExcel->setActiveSheetIndex($x1); //设置第一个Sheet，后面循环读取不同的sheet，每个sheet只有一首诗歌，后面做好了excel文件后，可以重新写这个部分
    
    if($link){
        //根据诗歌的名字找到对应的id，因为我在数据库中限制了；
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
    
    ////////////////////////////////////这里一次性把Excel文件里的图片都读出来了
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
        
        //我们把所有的图片都保存在一个临时目录下；
        $myFileName = 'file\tempimage\00_Image_'.++$i.'.'.$extension;
        file_put_contents($myFileName,$imageContents);
        
        $codata[][] = array();
        $codatacell[] = array();
        $codatacell[0] = $drawing->getCoordinates(); //得到单元数据 比如D13单元；
        $codatacell[1] = $myFileName;//得到对应的文件名称；
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
    
    //从第13行开始，到第21行结束，一共9行是知识大爆炸的
    for ($x=13; $x<=21; $x++) {
        $cellnumber1 = 'B'.$x;
        $cellnumber2 = 'C'.$x;
        $cellnumber3 = 'D'.$x;
        $cellnumber4 = 'E'.$x;
        
        $data2 = $objPHPExcel->getActiveSheet()->getCell($cellnumber1)->getValue();  //获取单元格B13的值，知识大爆炸知识点1的名字
        if(is_null($data2)){
            break;//如果为空，表示这行无数据；
        }
        $data21 = $objPHPExcel->getActiveSheet()->getCell($cellnumber2)->getValue();  //获取单元格C13的值，知识大爆炸知识点1的内容
        //$data22 = $objPHPExcel->getActiveSheet()->getCell($cellnumber3)->getValue();  //获取单元格D13的值，知识大爆炸知识点1的第一个图片
        //$data23 = $objPHPExcel->getActiveSheet()->getCell($cellnumber4)->getValue();  //获取单元格E13的值，知识大爆炸知识点1的第二个图片
        
        //先把文字插入
        $sql_insert1 = "INSERT INTO Poetry_knowledge SET Poetry_knowledgeid_FK=" .$poetryid."" . ",Poetry_knowledgename='".$data2."'" . ",Poetry_knowledgenote='".$data21."'";
        mysqli_query($link, "set names 'utf8'");
        $result_insert1 = mysqli_query($link, $sql_insert1);
        //echo ($result_insert1);
        $query = "select max(idPoetry_knowledge) from mp_wx_zxj_demo_mysql.poetry_knowledge";
        mysqli_query($link, "set names 'utf8'");
        $res = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($res);
        //echo($row);
        
        
        //我想得到这些图片到底是从哪个单元格中读取的；
        $ic=0;
        for ($ic=0; $ic<count($codata); $ic++) {
            //$codata = $drawing->getCoordinates(); //得到单元数据 比如D13单元
            //echo($codata);
            
            //$codatacell=$codata[$ic];
            //我们确定D列放入第一个图片；
            if(strcomp($codata[$ic][0],$cellnumber3)){
                //把新计算的数值逐一插入进去；
                $PSize = filesize($codata[$ic][1]);
                $mysqlPicture = addslashes(fread(fopen($codata[$ic][1], "r"), $PSize));
                //echo($codata[$ic][0]);
                //echo($cellnumber3);
                
                $sql_insert = "UPDATE Poetry_knowledge SET Poetry_knowledgepic1='".$mysqlPicture."'"." where idPoetry_knowledge=".$row["max(idPoetry_knowledge)"]."";//. ",Poetry_knowledgepic2='".$data23."'";
                mysqli_query($link, "set names 'utf8'");
                $result_insert = mysqli_query($link, $sql_insert);
                
                //echo( $sql_insert);
            }
            
            //我们确定E列放入第二个图片
            
            if(strcomp($codata[$ic][0],$cellnumber4)){
                //把新计算的数值逐一插入进去；
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
$data3 = $objPHPExcel->getActiveSheet()->getCell('B14')->getValue();  //获取单元格B13的值，知识大爆炸知识点1
$data4 = $objPHPExcel->getActiveSheet()->getCell('B15')->getValue();  //获取单元格B13的值，知识大爆炸知识点1
$data5 = $objPHPExcel->getActiveSheet()->getCell('B16')->getValue();  //获取单元格B13的值，知识大爆炸知识点1
$data6 = $objPHPExcel->getActiveSheet()->getCell('B17')->getValue();  //获取单元格B13的值，知识大爆炸知识点1
$data7 = $objPHPExcel->getActiveSheet()->getCell('B18')->getValue();  //获取单元格B13的值，知识大爆炸知识点1
$data8 = $objPHPExcel->getActiveSheet()->getCell('B19')->getValue();  //获取单元格B13的值，知识大爆炸知识点1
$data9 = $objPHPExcel->getActiveSheet()->getCell('B20')->getValue();  //获取单元格B13的值，知识大爆炸知识点1
$data10 = $objPHPExcel->getActiveSheet()->getCell('B21')->getValue();  //获取单元格B13的值，知识大爆炸知识点1
*/

if($link){
    /*
    $imgData=array();
    $imageFilePath='/images/'.date('Y/m/d').'/';//图片保存目录
    foreach($sheet->getDrawingCollection() as $img){
        list ($startColumn, $startRow) = PHPExcel_Cell::coordinateFromString($img->getCoordinates());//获取列与行号
        $imageFileName=$img->getCoordinates().mt_rand(100,999);
    //表格解析后图片会以资源形式保存在对象中，可以通过getImageResource函数直接获取图片资源然后写入本地文件中
    switch ($img->getMimeType()){//处理图片格式
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
    
    //这个方法可行，那么错误就在于从D13里面读取的是空的；问题找到
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
    
    //把新计算的数值逐一插入进去；
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

 

//写数据

//$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Hello');//指定要写的单元格位置 

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

//$objWriter->save('2.xls');

 

?>