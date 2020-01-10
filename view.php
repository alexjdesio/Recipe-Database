<?php include('header.php'); ?>

<?php
if(!isset($_GET['recipe'])){
 redirect('home.php');
}
else if (isset($_GET['delete'])){
  if($_GET['delete']=="true"){
    //remove temp file from the /images directory
    $query = 'SELECT * FROM recipe_table ';
    $query .= "WHERE " . 'recipe' ."='";
    $query .= urlencode($_GET['recipe']) . "'";
    echo $query;
    $content = mysqli_query($db,$query);
    $recipe_information = mysqli_fetch_assoc($content);
    unlink(urldecode($recipe_information['image_name']));

    //remove entry from database
    $db = connect_to_db();
    $query = 'DELETE from recipe_table ';
    $query .= "WHERE " . 'recipe' ."='";
    $query .= urlencode($_GET['recipe']) . "'";
    echo $query;
    mysqli_query($db,$query);
    redirect("home.php");
    //Add some kind of confirmation message if the delete is successful


  }
}

?>

<?php
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

<h1><?php echo urldecode($_GET['recipe'])?></h1>
<div id="two_column">
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
    <image style="margin-left: 160px; margin-top: 30px;" src="<?php echo urldecode($recipe_information['image_name'])?>">
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


<a style="color:red;" href="view.php?recipe=<?php echo urldecode($_GET['recipe'])?>&delete=true">Delete Recipe</a>
  <?php
  mysqli_free_result($content);
  mysqli_close($db);
  ?>
</div>

</body>
