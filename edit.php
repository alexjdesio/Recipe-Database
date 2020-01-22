<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Edit Recipe - <?php echo $_GET['recipe'] ?> | Recipe Database</title>
</head>

<?php include('header.php'); ?>

<?php
$db = connect_to_db();
$query = 'SELECT * FROM recipe_table ';
$query .= "WHERE " . 'recipe' ."='";
$query .= urlencode($_GET['recipe']) . "'";
echo $query;
$content = mysqli_query($db,$query);
$recipe_information = mysqli_fetch_assoc($content);

if(is_get_request()){ // for a get request, display the form with the values in the database
  if(!isset($_GET['recipe'])){ //checks to make sure there is a recipe to edit with the given name
   redirect('new.php');
  }
  if(urldecode($recipe_information['recipe']) != $_GET['recipe']){ //if there is already a recipe with the intended name
    redirect('new.php');
  }
}
if (is_post_request()){ // for a post request, update the database and redirect to the updated view.php entry
  $db = connect_to_db();

  $file_types = ['image/png','image/bmp','image/gif','image/jpeg','image/jpg','image/png'];
  $image_directory = "images/";
  $target_image = $image_directory . basename($_FILES['image_file']['tmp_name']);
  $upload = 1;
  $file_moved = 0;

  if(file_exists($target_image)){
    $upload = 0;
    echo "File already exists";
  }
  if($_FILES['image_file']['size']>65000){
    $upload = 0;
    echo "File is too large";
  }
  //validate that the file is an image

  if($upload == 1){
    if(move_uploaded_file($_FILES['image_file']['tmp_name'],$target_image)){
      echo "File uploaded successfully.<br>";
      $file_moved = 1;
    }
  }

  $query = 'UPDATE recipe_table ';
  $query .= "SET ";
  $query .= "recipe='" . urlencode(h($_POST['recipe_name'])) . "',";
  $query .= "tags='" . urlencode(h($_POST['recipe_tags'])) . "',";
  $query .= "servings='" . $_POST['recipe_servings'] . "',";
  $query .= "date='" . date('m/d/y') . "',";
  $query .= "ingredients='" . h(urlencode($_POST['recipe_ingredients'])) . "',";
  $query .= "directions='" . h(urlencode($_POST['recipe_directions'])) . "',";
  if($upload == 1){ //if the image was successfully updated,
    $query .= "image_name='" . urlencode($target_image) . "'";
  }
  else{
    $query .= "image_name='" . $recipe_information['image_name'] . "'";
  }
  $query .= " where recipe='";
  $query .= $recipe_information['recipe'] ."';";

  echo $query;
  if(mysqli_query($db,$query)){
    $new_page = "view.php?recipe=" . urlencode($_POST['recipe_name']);
    redirect($new_page);
  }
  else{
    echo "<p>One or more errors prevented the recipe from being updated.</p>";
  }

}

?>

<h2 class="form_title">Edit Recipe: <?php echo urldecode($recipe_information['recipe'])?></h2>
<div id="search_form">
      <form id="new_recipe" action="" method="post" enctype="multipart/form-data">
        <p>Recipe Name</p>
        <input type="text" name="recipe_name" value="<?php echo urldecode($recipe_information['recipe'])?>" maxlength="255" >
        <p>Tags</p>
        <input type="text" name="recipe_tags" value="<?php echo $recipe_information['tags']?>" maxlength="255" >
        <p>Servings</p>
        <input type="number" name="recipe_servings" min="1" max="72" value="<?php echo $recipe_information['servings']?>">
        <p>Ingredients</p>
        <textarea form="new_recipe" class="large_input" rows="10" columns="100" name="recipe_ingredients" maxlength="2999"><?php echo urldecode($recipe_information['ingredients'])?></textarea>
        <p>Directions</p>
        <textarea form="new_recipe" class="large_input" rows="10" columns="100" name="recipe_directions" maxlength="2999"><?php echo urldecode($recipe_information['directions'])?></textarea>
        <p>Replace Current Image</p>
        <br style="clear:both;">
        <image style="" src="<?php echo urldecode($recipe_information['image_name'])?>">
        <br style="clear:left;">
        <input style="margin: 10px;" type="file" name="image_file" accept="image/*">
        <br style="clear:left;">
        <input style="margin-left: 120px;" type="submit" name="submit_form" value="Create Recipe" >
        <br>
    </form>
</div>

</body>
</html>
