<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Edit Recipe - <?php echo $_GET['recipe'] ?> | Recipe Database</title>
</head>

<?php include('header.php'); ?>

<?php
//Retrieves existing information from the database for the given recipe name
$db = connect_to_db();
$query = 'SELECT * FROM recipe_table ';
$query .= "WHERE " . 'recipe' ."='";
$query .= urlencode($_GET['recipe']) . "'";
echo $query;
$content = mysqli_query($db,$query);
$recipe_information = mysqli_fetch_assoc($content);

if(is_get_request()){ // For a get request, display the form with the values in the database
  if(!isset($_GET['recipe'])){ //Checks to make sure the url query string contains a variable for the recipe name
   redirect('new.php');
  }
  if(urldecode($recipe_information['recipe']) != $_GET['recipe']){ //If there are no entries in the database with the given recipe name, redirect to new.php
    redirect('new.php');
  }
}
if (is_post_request()){ // For a post request, update the database entry for the recipe and redirect to the updated view.php entry
  $db = connect_to_db();

  //TODO: Check the mime type of the image before accepting it
  $accepted_extensions = ['png','bmp','gif','jpg','jpeg'];
  $accepted_mime_types = ['image/png','image/bmp','image/gif','image/jpeg','image/jpg','image/png'];
  $image_directory = "images/";
  $target_image = $image_directory . basename($_FILES['image_file']['tmp_name']);
  $file_type = $_FILES['image_file']['type'];
  $file_extension = file_extension(basename($_FILES['image_file']['name']));
  $upload = 1;
  $file_moved = 0;

  if(file_exists($target_image)){ //Makes sure that the file does not already exist
    $upload = 0;
    echo "File already exists<br>";
  }
  elseif($_FILES['image_file']['size']>65000){ //Makes sure that the file is an appropriate size
    $upload = 0;
    echo "File is too large<br>";
  }
  elseif(!in_array($file_type,$accepted_mime_types)){ //Makes sure that the file is an acceptable MIME TYPE
    $upload = 0;
    echo "File is not a valid image type<br>";
  }
  elseif(!in_array($file_extension,$accepted_extensions)){ //Makes sure that the file has an acceptable extension
    $upload = 0;
    echo "File does not have a valid image extension<br>";
  }
  elseif(!getimagesize($_FILES['image_file']['tmp_name'])){ //Checks to make sure that the file is an image by requesting the dimensions of the image
    $upload = 0;
    echo "File is not an image<br>";
  }
  elseif(contains_php($_FILES['image_file']['tmp_name'])){
    $upload = 0;
    echo "File should not contain php<br>";
  }

  if($upload == 1){
    if(move_uploaded_file($_FILES['image_file']['tmp_name'],$target_image)){
      echo "File uploaded successfully.<br>";
      $file_moved = 1;
    }
  }

  //Updates the existing entry in the database with the new information provided by the form
  $query = 'UPDATE recipe_table ';
  $query .= "SET ";
  $query .= "recipe='" . urlencode(h($_POST['recipe_name'])) . "',";
  $query .= "tags='" . urlencode(h($_POST['recipe_tags'])) . "',";
  $query .= "servings='" . $_POST['recipe_servings'] . "',";
  $query .= "date='" . date('m/d/y') . "',";
  $query .= "ingredients='" . h(urlencode($_POST['recipe_ingredients'])) . "',";
  $query .= "directions='" . h(urlencode($_POST['recipe_directions'])) . "',";
  if($upload == 1){ //if the image was successfully updated, replace the image name in the database
    $query .= "image_name='" . urlencode($target_image) . "'";
  }
  else{
    $query .= "image_name='" . $recipe_information['image_name'] . "'";
  }
  $query .= " where recipe='";
  $query .= $recipe_information['recipe'] ."';";

  echo $query;
  if(mysqli_query($db,$query)){ //Redirects to the view.php entry for the given recipe if the recipe was updated successfully
    $new_page = "view.php?recipe=" . urlencode($_POST['recipe_name']);
    //If recipe entry was updated successfully, remove the old image from the images directory
    if(!unlink(urldecode($recipe_information['image_name']))){
      echo "Image could not be deleted<br>";
    }
    else{
      redirect($new_page);
    }

  }
  else{
    echo "One or more errors prevented the recipe from being updated.<br>";
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
