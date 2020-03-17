<?php

include_once('connection.php');

if(empty($_FILES['newimg']['name'])){
    $file_name = $_POST['oldimg'];
}
else{
    $errors = array();
    $file_name = $_FILES['newimg']['name'];
    $file_size = $_FILES['newimg']['size'];
    $file_tmp = $_FILES['newimg']['tmp_name'];
    $file_type = $_FILES['newimg']['type'];
    $file_ext = end(explode('.',$file_name));
    $extensions = array('jpeg','jpg','png');

    #checking file extension
    if(in_array($file_ext,$extensions) == false)
      $errors[] = "Extension not allowed, Please choose a jpeg or png";

    #checking size of file
    if($file_size > 2097152 )
      $errors[] = 'File must be 2MB or lower';

    if(empty($errors)  == true)
    {
      move_uploaded_file($file_tmp,$cat_image_location.$file_name);
    }
    else
    {
      print_r($errors);
      die();
    }
}

$cid = $_POST['cat_id'];
$cat_name = $_POST['newcatname'];

echo $sql = "UPDATE category SET cat_name = '{$cat_name}',cat_img ='{$file_name}' WHERE cat_id = {$cid}";

$result = mysqli_query($conn,$sql) or die("unsucessful");

if($result){
    header("Location: http://localhost/pc-cart/pccart/admin/category.php");  
}

mysqli_close($conn);

?>