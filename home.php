<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Home | Recipe Database</title>
</head>

<?php include('header.php'); ?>
<body>
<?php
if(isset($_GET['deleted'])){ //Notifies user if recipe was successfully deleted
  if($_GET['deleted']=='successful'){
    echo "Recipe deleted succesfully";
  }
}
 ?>
<div style="text-align: center;">
  <h1>Recipe Database</h1>

  <h2>Newest Recipes</h2>
  <table style="margin: 0 auto;">
    <tr class="table_header">
      <td>Recipe </td>
      <td>Tags </td>
      <td>Serves </td>
      <td>Date Added</td>
    </tr>
    <?php
    $db = connect_to_db();

    //Retrieves all entries in the table ordered by date
    $query = 'SELECT * FROM recipe_table ';
    $query .= 'ORDER BY date ASC;';
    $content = mysqli_query($db,$query);
    ?>

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
</div>

</body>
