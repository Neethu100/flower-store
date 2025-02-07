<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   //$flower_1 = mysqli_real_escape_string($conn, $_POST['flower_1']);
   //$flower_2= mysqli_real_escape_string($conn, $_POST['flower_2']);
   //$bouquet_type= mysqli_real_escape_string($conn, $_POST['bouquet_type']);
   //$wrapping_type= mysqli_real_escape_string($conn, $_POST['wrapping_type']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/'.$image;

   echo "hai";

   $select_bouquets_name = mysqli_query($conn, "SELECT name FROM `bouquets` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_bouquets_name) > 0){
      $message[] = 'bouquet name already exist!';
   }else{
      $insert_bouquets = mysqli_query($conn, "INSERT INTO `bouquets`(name,price,image) VALUES('$name','$price','$image')") or die('query failed');

      if($insert_bouquets){
         if($image_size > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folter);
            $message[] = 'bouquet added successfully!';
         }
      }
   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($conn, "SELECT image FROM `bouquets` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `bouquets` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
  
   mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
   header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>bouquets</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add new bouquet</h3>
      <input type="text" class="box" required placeholder="enter bouquet name" name="name">
      <!--
            <h2>flower type</h2>
      <p>flower 1:</p>
      <select name="flower_1">
        <option value="">--select--</option>
        <option value="f1">f1</option>
        <option value="f2">f2</option>
</select><br>
<p>flower 2:</p>
<select name="flower_2">
        <option value="">--select--</option>
        <option value="f2">f1</option>
        <option value="f2">f2</option>
</select><br>
<p>bouquet type:</p>
<select name="bouquets_type">
        <option value="">--select--</option>
        <option value="b1">b1</option>
        <option value="b2">b2</option>
</select><br>
<p>wrapping type:</p>
<select name="wrapping_type">
        <option value="">--select--</option>
        <option value="w1">w1</option>
        <option value="w2">w2</option>
</select><br>
-->


      <input type="number" min="0" class="box" required placeholder="enter bouquets price" name="price">

      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
      <input type="submit" value="add bouquet" name="add_bouquet" class="btn">
   </form>

</section>

<section class="show-products">

   <div class="box-container">

      <?php
         $select_bouquets = mysqli_query($conn, "SELECT * FROM `bouquets`") or die('query failed');
         if(mysqli_num_rows($select_bouquets) > 0){
            while($fetch_broquets = mysqli_fetch_assoc($select_bouquets)){
      ?>
      <div class="box">
         <div class="price">$<?php echo $fetch_bouquets['price']; ?>/-</div>
         <img class="image" src="uploaded_img/<?php echo $fetch_bouquets['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_bouquets['name']; ?></div>
    
         <a href="admin_update_bouquets.php?update=<?php echo $fetch_bouquets['id']; ?>" class="option-btn">update</a>
         <a href="admin_bouquets.php?delete=<?php echo $fetch_bouquets['id']; ?>" class="delete-btn" onclick="return confirm('delete this bouquets?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no bouquet added yet!</p>';
      }
      ?>
   </div>
   
</section>

<script src="js/admin_script.js"></script>

</body>
</html>