<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<?php include('header.php'); ?>

<?php

require_once('init.php');
if(is_post_request()){
  $recipe_name = $_POST['recipe_name'] ?? ' ';
  $recipe_tags = $_POST['recipe_tags'] ?? ' ';
  $recipe_hours = $_POST['recipe_hours'] ?? ' ';
  $recipe_minutes = $_POST['recipe_minutes'] ?? ' ';
  $recipe_servings = $_POST['recipe_servings'] ?? ' ';
  $recipe_ingredients = $_POST['recipe_ingredients'] ?? ' ';
  $recipe_directions = $_POST['recipe_directions'] ?? ' ';

  echo "<h3>Recipe Overview</h3> " . "<br />";
  echo "Name: " . $recipe_name . "<br />";
  echo "Tags: " . $recipe_tags . "<br />";

  echo "Cook Time: ";
  if ($recipe_hours != 0) {
      echo $recipe_hours;
      if ($recipe_hours == 1) echo " hour ";
      else echo " hours ";
  }
  if ($recipe_minutes != 0) {
      echo $recipe_minutes;
      if ($recipe_minutes == 1) echo " minute <br />";
      else echo " minutes <br />";
  }
  echo "Serves: " . $recipe_servings . "<br />";
  echo "Ingredients: " . $recipe_ingredients . "<br />"; //this would work better as an associative array
  echo "Directions: " . $recipe_directions . "<br />";
}

else{
  redirect('new.php');
}
?>
<body>
<h2 class="form_title">Edit Recipe</h2>
<div id="search_form">
    <form action="/recipe_database/new_recipe.php" method="post">
        <p>Recipe Name</p>
        <input type="text" name="recipe_name" value="" />
        <p>Tags</p>
        <input type="text" name="recipe_tags" value="" />
        <h3>Cook Time</h3>
        <p>Hours</p>
        <input type="number" name="recipe_hours" value="" min="0" max="168" />
        <br>
        <p>Minutes</p>
        <input type="number" name="recipe_minutes" value="" min="0" max="60" />
        <p>Servings</p>
        <input type="number" name="recipe_servings" value="" min="1" max="72"/>
        <p>Ingredients</p>
        <input class="large_input" type="text" name="recipe_ingredients" value="" />
        <p>Directions</p>
        <input class="large_input" type="text" name="recipe_directions" value="" />

        <div class="input_h">
            <p>Check box</p>
            <input type="checkbox" name="checkbox" value="0" />
        </div>
        <br>
        <div class="input_h">
            <p>Search</p>
            <input type="search" name="search" value="Enter Here" />
        </div>
        <br>
        <div class="input_h">
            <p>Submit</p>
            <input type="submit" name="submit_form"value="Create Recipe" />
        </div>
        <br>
    </form>
</div>
</body>
