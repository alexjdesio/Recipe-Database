<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>New Recipe | Recipe Database</title>
</head>

<body>
<?php include('header.php'); ?>


<?php

if (is_post_request()){
  $db = connect_to_db();
  //handle multiples with the same name

  $query = 'INSERT into recipe_table ';
  $query .= "VALUES ('";
  $query .= urlencode(h($_POST['recipe_name'])) . "','";
  $query .= urlencode(h($_POST['recipe_tags'])) . "','";
  $query .= $_POST['recipe_servings'] . "','";
  $query .= date('m/d/y') . "','";
  $query .= h($_POST['recipe_ingredients']) . "','";
  $query .= h($_POST['recipe_directions']);
  $query .= "');";
  echo $query;
  if(mysqli_query($db,$query)){
    $new_page = "view.php?recipe=" . urlencode($_POST['recipe_name']);
    redirect($new_page);
  }



}


 ?>


<h2 class="form_title">Add Recipe</h2>
<div id="search_form">
      <form id="new_recipe" action="" method="post">
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
        <input style="margin-left: 120px;" type="submit" name="submit_form"value="Create Recipe" >
        </div>
        <br>
    </form>
</div>







</body>
</html>
