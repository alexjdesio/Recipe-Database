<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>New Recipe | Recipe Database</title>
</head>

<body>
<?php include('header.php'); ?>


<?php
if (is_post_request()){
  //Queries database to make sure that submission has a unique recipe name
  $db = connect_to_db();
  $query = 'SELECT * FROM recipe_table ';
  $query .= "WHERE " . 'recipe' ."='";
  $query .= urlencode($_POST['recipe_name']) . "'";
  echo $query . "<br>";
  $content = mysqli_query($db,$query);
  $recipe_information = mysqli_fetch_assoc($content);
  if($recipe_information['recipe'] == urlencode($_POST['recipe_name'])){ //Checks if there is already a recipe with the same name
    echo "There is already a recipe with this name<br>";
  }
  else{
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


    //Query adds entry to the database if successful
    //User input is processed to prevent SQL injection as well as issues with url query strings before being stored in the database
    $query = 'INSERT into recipe_table ';
    $query .= "VALUES ('";
    $query .= urlencode(h($_POST['recipe_name'])) . "','";
    $query .= urlencode(h($_POST['recipe_tags'])) . "','";
    $query .= $_POST['recipe_servings'] . "','";
    $query .= date('m/d/y') . "','";
    $query .= h(urlencode($_POST['recipe_ingredients'])) . "','";
    $query .= h(urlencode($_POST['recipe_directions'])) . "','";
    $query .= urlencode($target_image);
    $query .= "');";

    if($file_moved == 1){
      echo $query;
      if(mysqli_query($db,$query)){ //Redirects the user to the view.php page for the new recipe if it was successfully added.
        $new_page = "view.php?recipe=" . urlencode($_POST['recipe_name']);
        redirect($new_page);
      }
      else{
        echo "<p>One or more errors prevented the recipe from being added.</p>";
      }
    }
  }
}
?>

<h2 class="form_title">Add Recipe</h2>
<div id="search_form">
      <form id="new_recipe" action="" method="post" enctype="multipart/form-data">
        <p>Recipe Name</p>
        <input type="text" name="recipe_name" value="" maxlength="255" >
        <p>Tags</p>
        <input type="text" name="recipe_tags" value="" maxlength="255" >
        <p>Servings</p>
        <input type="number" name="recipe_servings" min="1" max="72" value="">
        <p>Ingredients</p>
        <textarea form="new_recipe" class="large_input" rows="10" columns="100" name="recipe_ingredients" value="" maxlength="2999"></textarea>
        <p>Directions</p>
        <textarea form="new_recipe" class="large_input" rows="10" columns="100" name="recipe_directions" value="" maxlength="2999"></textarea>
        <div class="input_h">
        <p>Upload Image</p>
        <input type="file" name="image_file" accept="image/*">
        <br style="clear:left;">
        <input style="margin-left: 120px;" type="submit" name="submit_form" value="Create Recipe" >
        </div>
        <br>
    </form>
</div>

</body>
</html>
