<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Search | Recipe Database</title>
</head>

<body>
<?php include('header.php'); ?>

<?php
if(isset($_GET['search'])){ //Checks the url query string for a value to search by

$db = connect_to_db();
$search_type = $_GET['search_type'] ?? 'recipe'; //Search type is optional, assumed to be recipe name if not provided in the url query string

//Queries database for all entries matching the search parameters
$query = 'SELECT * FROM recipe_table ';
$query .= "WHERE " . $search_type ."='";
$query .= urlencode($_GET['search']) . "'";
echo $query;
$content = mysqli_query($db,$query);
?>

<form action="" method="get">
  <input type="submit" value="Search again">
</form>


<table style="margin: 0 auto;">
  <tr class="table_header">
    <td>Recipe </td>
    <td>Tags </td>
    <td>Serves </td>
    <td>Date Added</td>
  </tr>

   <?php //Displays all entries matching search parameters in table form ?>
   <?php while($curr_row = mysqli_fetch_assoc($content)){ ?>
   <tr class="home_table_row">
     <td><a href="view.php?recipe=<?php echo h($curr_row['recipe'])?>"><?php echo urldecode(h($curr_row['recipe']))?></a></td>
     <td><?php echo urldecode(h($curr_row['tags'])) ?></td>
     <td><?php echo h($curr_row['servings'])?></td>
     <td><?php echo h($curr_row['date'])?></td>
   </tr>
   <?php } ?>


</table>
<?php
mysqli_free_result($content);
mysqli_close($db);
?>

<?php
} //Displays the search form if the get request did not contain a value to search by
else{
  echo '
  <h2 class="form_title">Find Recipe</h2>
  <div id="search_form">
      <form action="" method="get">
          <div class="input_h">
          <p>Search by:</p>
          <select name="search_type">
            <option name="search_type1" value="recipe">Recipe name</option>
            <option name="search_type2" value="tags">Tags</option>
            <option name="search_type3" value="servings">Servings</option>
          </select>
          </div>
          <br>
          <div class="input_h">
              <p>Enter value</p>
              <input type="search" name="search" value="" placeholder="Find a Recipe" />
          </div>
          <br>
          <div style="margin-left: 100px;" class="input_h">
              <input type="submit" value="Submit" />
          </div>
          <br>
      </form>
  </div>
  ';
}

?>






</body>
</html>
