<?php include('header.php'); ?>

<?php
if(!isset($_GET['recipe'])){
 redirect('home.php'); //Redirects the user to home.php if there is no recipe in the url query string
}
else if (isset($_GET['delete'])){
  if($_GET['delete']=="true"){ //Removes the recipe entry from the database
    $db = connect_to_db();
    $query = 'SELECT * FROM recipe_table ';
    $query .= "WHERE " . 'recipe' ."='";
    $query .= urlencode($_GET['recipe']) . "'";
    echo $query;
    $content = mysqli_query($db,$query);
    $recipe_information = mysqli_fetch_assoc($content);

    //Deletes image from images directory
    if(!unlink(urldecode($recipe_information['image_name']))){
      echo "Image could not be deleted";
    }
    else{
      //Removes entry from database if the image was deleted
      $db = connect_to_db();
      $query = 'DELETE from recipe_table ';
      $query .= "WHERE " . 'recipe' ."='";
      $query .= urlencode($_GET['recipe']) . "'";
      echo $query;
      if(mysqli_query($db,$query)){
        redirect("home.php?deleted=successful");
      }
      else{
        echo "Recipe could not be deleted.<br>";
      }
    }
    //TODO:Add confirmation message if delete was successful
  }
}

?>

<?php
//Retrieves entry from database for a given recipe name
$db = connect_to_db();
$query = 'SELECT * FROM recipe_table ';
$query .= "WHERE " . 'recipe' ."='";
$query .= urlencode($_GET['recipe']) . "'";
echo $query;
$content = mysqli_query($db,$query);
$recipe_information = mysqli_fetch_assoc($content);
?>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title><?php echo urldecode($_GET['recipe'])?> | Recipe Database</title>
</head>
<body>

<h1 style="margin-bottom: 10px;"><?php echo urldecode($_GET['recipe'])?></h1>
<a style="margin-left: 10px; font-size: 12px;" href=<?php echo "edit.php?recipe=" . urlencode($_GET['recipe']); ?>>Edit Recipe</a>
<div style="padding-top: 20px;" id="two_column">
  <div id="right_column">
    <ul class="viewrecipe">
      <li>Added on: <?php echo $recipe_information['date']?></li>
      <li>Tags: <?php echo urldecode($recipe_information['tags'])?></li>
      <li><?php echo $recipe_information['servings'] ?> Servings</li>
    </ul>

    <h2>Ingredients</h2>
    <ul>
      <?php $ingredients_list = explode('%0A',$recipe_information['ingredients']);
      foreach($ingredients_list as $ingredient){
        echo "<li class=\"ingredients\">" . urldecode($ingredient) . "</li>";
      }
      ?>
    </ul>
  </div>

  <div id="right_column">
    <image style="margin-left: 160px; margin-top: 30px;" width="500px" height="300px" src="<?php echo urldecode($recipe_information['image_name'])?>">
  </div>

</div>

<div class="spacer" style="height: 10px;"></div>
<h2>Directions</h2>
<ol>
  <?php $directions = explode('%0A',$recipe_information['directions']);
  foreach($directions as $direction){
    if(urldecode($direction) != ''){
      echo "<li class=\"directions\">" . urldecode($direction) . "</li>";
    }
  }
  ?>
</ol>


<a style="color:red;" href="view.php?recipe=<?php echo urlencode($_GET['recipe'])?>&delete=true">Delete Recipe</a>
  <?php
  mysqli_free_result($content);
  mysqli_close($db);
  ?>
</div>

</body>
