<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<?php include('header.php'); ?>


<?php

if (is_post_request()){
  $curr_date = date('m/d/y');

  $db = connect_to_db();
  $query = 'INSERT into recipe_table ';
  $query .= "VALUES ('" . $_POST['recipe_name']. "','" . $_POST['recipe_tags'] . "','" . $_POST['recipe_servings'] . "','" . $curr_date;
  $query .= "');";
  echo $query;
  mysqli_query($db,$query);

}


 ?>


<h2 class="form_title">Add Recipe</h2>
<div id="search_form">
      <form action="" method="post">
        <p>Recipe Name</p>
        <input type="text" name="recipe_name" value="" >
        <p>Tags</p>
        <input type="text" name="recipe_tags" value="" >
        <p>Servings</p>
        <input type="number" name="recipe_servings" min="1" max="72" value="">
        <p>Ingredients</p>
        <input class="large_input" type="text" name="recipe_ingredients" value="" >
        <p>Directions</p>
        <input class="large_input" type="text" name="recipe_directions" value="" >
        <div class="input_h">
        <input style="margin-left: 120px;" type="submit" name="submit_form"value="Create Recipe" >
        </div>
        <br>
    </form>
</div>







</body>
</html>
