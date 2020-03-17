<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/loginstyle.css">
</head>
<body>    

<?php
    include_once('connection.php');
        $id= $_GET['pid'];
        $qry="SELECT * FROM person WHERE person_id={$id}";
        $res= mysqli_query($conn,$qry) or die("unsuccessful");
        
	if(mysqli_num_rows($res) > 0)   {
        while($row = mysqli_fetch_assoc($res)) {
 ?>

<form class="post-form" action="upadtedata.php" method="POST">
<div class="form-group">
    <label>FullName</label>
    <input type="hidden" name="person_id" value="<?php echo $row['person_id']; ?>"/>
    <input type="text" name="newName" value="<?php echo $row['FirstName']; ?>"/>   
</div>

<div class="form-group">
    <label>Email</label>
    <input type="text" name="Email" value="<?php echo $row['Email']; ?>"/>   
</div>
<input class="submit" type="submit" value="update">
</form>

<?php
    }
}
?>

    </body>
    </html>