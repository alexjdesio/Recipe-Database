<?php include('header.php'); ?>

<?php
if(!isset($_GET['recipe'])){
 redirect('home.php');
}
else if (isset($_GET['delete'])){
  if($_GET['delete']=="true"){
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

<h1><?php echo urldecode($_GET['recipe'])?></h1>
<p style="font-size: 14px; margin-left: 40px;">Added on: <?php echo $recipe_information['date']?></p>
<ul class="viewrecipe">
  <li>Tags: <?php echo urldecode($recipe_information['tags'])?></li>
  <li><?php echo $recipe_information['servings'] ?> Servings</li>
</ul>

<h2>Ingredients</h2>
<p class="ingredients"><?php echo $recipe_information['ingredients'] ?? "";?></p>
<div class="spacer" style="height: 30px;"></div>
<h2>Directions</h2>
<p class="directions"><?php echo $recipe_information['directions'] ?? "";?></p>



<a style="color:red;" href="view.php?recipe=<?php echo urldecode($_GET['recipe'])?>&delete=true">Delete Recipe</a>
  <?php
  mysqli_free_result($content);
  mysqli_close($db);
  ?>
</div>
