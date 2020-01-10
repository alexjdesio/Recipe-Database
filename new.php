<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>New Recipe | Recipe Database</title>
</head>

<body>
<?php include('header.php'); ?>


<?php




if (is_post_request()){
  /* image processing steps:
     -check mime type
     -upload it
     -figure out how to position it so that we can get its directory as well
     -display it on view.php
  */
  $file_types = ['image/png','image/bmp','image/gif','image/jpeg','image/jpg','image/png'];
  $image_directory = "images/";
  $target_image = $image_directory . basename($_FILES['image_file']['tmp_name']);
  $upload = 1;

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
      echo "File uploaded successfully.";
    }
  }

  //uploading relevant information to the database

  $db = connect_to_db();
  //handle multiples with the same name

  $query = 'INSERT into recipe_table ';
  $query .= "VALUES ('";
  $query .= urlencode(h($_POST['recipe_name'])) . "','";
  $query .= urlencode(h($_POST['recipe_tags'])) . "','";
  $query .= $_POST['recipe_servings'] . "','";
  $query .= date('m/d/y') . "','";
  //$list_ingredients = str_replace('\n','%0A',$_POST['recipe_ingredients']) ?? $_POST['recipe_ingredients'];
  $query .= h(urlencode($_POST['recipe_ingredients'])) . "','";
  //$query .= h(urlencode($list_ingredients)) . "','";
  $query .= h(urlencode($_POST['recipe_directions'])) . "','";
  $query .= urlencode($target_image);
  $query .= "');";
  echo $query;
  if(mysqli_query($db,$query)){
    $new_page = "view.php?recipe=" . urlencode($_POST['recipe_name']);
    redirect($new_page);
  }
  else{
    echo "<p>One or more errors prevented the recipe from being added.</p>";
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
        <textarea form="new_recipe" class="large_input" rows="10" columns="100" name="recipe_ingredients" value="" maxlength="2999">
        </textarea>
        <p>Directions</p>
        <textarea form="new_recipe" class="large_input" rows="10" columns="100" name="recipe_directions" value="" maxlength="2999">
        </textarea>
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
