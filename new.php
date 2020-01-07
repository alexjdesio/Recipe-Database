<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<?php include('header.php'); ?>


<?php

if(is_get_request()){
  //display form
}
else if (is_post_request()){
  //redisplay form with error messages if an error occurs
}


 ?>


<h2 class="form_title">Add Recipe</h2>
<div id="search_form">
      <form action="" method="post">
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
            <p>Submit</p>
            <input type="submit" name="submit_form"value="Create Recipe" />
        </div>
        <br>
    </form>
</div>







</body>
</html>
