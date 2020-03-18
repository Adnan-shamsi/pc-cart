<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="css/loginstyle.css">

</head>
<body>

<?php
    include_once('connection.php');
    if(!isset($_GET['pid']))
       die("<h2 style='text-align:center;'>NO ID ???</h2> ");
        $id= $_GET['pid'];
        $qry="SELECT * FROM person WHERE person_id= {$id}";
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
