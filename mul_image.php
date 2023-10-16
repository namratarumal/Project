<?php
$con=mysqli_connect("localhost","root","","test");
if(isset($_POST['submit']))
{
    $name=$_POST['name'];
    $totalimage=count($_FILES['image']['name']);
    $imagearray=array();
    for($i=0; $i<$totalimage; $i++)
    {
        $filename=array($_FILES['image']['name'][$i]);
        $mulimage=implode(",",$filename);
        $filetmpname=$_FILES['image']['tmp_name'][$i];
        $filestore="image/".$mulimage;

        if(move_uploaded_file($filetmpname,$filestore))
        {
            array_push($imagearray,$filestore);
        }

    }

    $imagejson=json_encode($imagearray);
    $sql="insert into mul_image(name,image_upload)values('$name','$imagejson')";
    if(mysqli_query($con,$sql))
    {
        echo "data insert";
    }
    else
    {
        echo "error".$con->error;
    }
}
?>
<html>
    <form method="post" enctype="multipart/form-data">
        enter name:<input type="text" name="name" ><br>
        <input type="file" name="image[]" multiple><br>
        <input type="submit" name="submit" value="submit">
    </form>
<table border=1>
    <tr>
    <th>Id</th>
        <th>Name</th>
        <th>image</th>
    </tr>

<?php
$sql1="select * from mul_image";
$res=mysqli_query($con,$sql1);
$img_array=array();
while($rw=mysqli_fetch_array($res))
{
    ?>
    <tr>
    <td><?php echo $rw['id'];?></td>
    <td><?php echo $rw['name'];?></td>
    <?php
    $img_array=json_decode($rw['image_upload']);
    foreach($img_array as $key=>$value)
 {
   ?>
   <td><img src="<?php echo $value;?>" width="80" height="80"></td>
   <?php
 }
 ?>
 </tr>
 <?php
}
 
?>
</table>
</html>