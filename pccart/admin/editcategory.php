<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/loginstyle.css">
</head>
<body>    

<?php
    include_once('connection.php');
        $id= $_GET['cid'];
        $qry="SELECT * FROM category WHERE cat_id={$id}";
        $res= mysqli_query($conn,$qry) or die("unsuccessful");
        
	if(mysqli_num_rows($res) > 0)   {
        while($row = mysqli_fetch_assoc($res)) {
            $img=$row["cat_img"];     
 ?>

<form class="post-form" action="upadtecategory.php" method="POST">
<div class="form-group">
    <label>Category Name</label>
    <input type="hidden" name="cat_id" value="<?php echo $row['cat_id']; ?>"/>
    <input type="text" name="newcatname" value="<?php echo $row['cat_name']; ?>"/><br>   
</div>

<div class="form-group">
        <label for="">Select Image:</label>
        <input type="file" id="newimg" name="newimg" >
        <img src="<?php echo $cat_image_location.$img; ?>" alt="" border="3" height="150" width="150"></img> 
        <input type="hidden" name="oldimg" value="<?php echo $row['cat_img']; ?>"/>
</div>
<input class="submit" type="submit" value="update">
</form>

<?php
    }
}
?>

    </body>
    </html>