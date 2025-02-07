<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_product'])){

   $update_b_id = $_POST['update_b_id'];
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
 

   mysqli_query($conn, "UPDATE `bouquets` SET name = '$name', price = '$price' WHERE id = '$update_b_id'") or die('query failed');

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/'.$image;
   $old_image = $_POST['update_b_image'];
   

if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'image file size is too large!';
      }else{
         mysqli_query($conn, "UPDATE `bouquets` SET image = '$image' WHERE id = '$update_b_id'") or die('query failed');
         move_uploaded_file($image_tmp_name, $image_folter);
         unlink('uploaded_img/'.$old_image);
         $message[] = 'image updated successfully!';
      }
   }

   $message[] = 'product updated successfully!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
<?php @include 'admin_header.php'; ?>

<section class="update-product">

<?php

   $update_id = $_GET['update'];
   $select_bouquets = mysqli_query($conn, "SELECT * FROM `bouquets` WHERE id = '$update_id'") or die('query failed');
   if(mysqli_num_rows($select_bouquets) > 0){
      while($fetch_bouquets = mysqli_fetch_assoc($select_bouquets)){
?>


<form action="" method="post" enctype="multipart/form-data">
   <img src="uploaded_img/<?php echo $fetch_bouquets['image']; ?>" class="image"  alt="">
   <input type="hidden" value="<?php echo $fetch_bouquets['id']; ?>" name="update_b_id">
   <input type="hidden" value="<?php echo $fetch_bouquets['image']; ?>" name="update_b_image">
   <input type="text" class="box" value="<?php echo $fetch_bouquets['name']; ?>" required placeholder="update product name" name="name">
   <input type="number" min="0" class="box" value="<?php echo $fetch_bouquets['price']; ?>" required placeholder="update product price" name="price">
      <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="image">
   <input type="submit" value="update product" name="update_product" class="btn">
   <a href="admin_bouquets.php" class="option-btn">go back</a>
</form>
<?php
      }
   }else{
      echo '<p class="empty">no update product select</p>';
   }
?>

</section>