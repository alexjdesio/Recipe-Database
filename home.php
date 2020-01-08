<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<?php include('header.php'); ?>

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
    //need to fix the url portion to link to a get request to view.php once view.php is created
    //additionally, redo the table so that there is an id as well or the date works or other hidden values
    $db = connect_to_db();

    $query = 'SELECT * FROM recipe_table ';
    $query .= 'ORDER BY date ASC;';
    $content = mysqli_query($db,$query);
    ?>

     <?php while($curr_row = mysqli_fetch_assoc($content)){ ?>
     <tr class="home_table_row">
       <td><a href="<?php echo h($curr_row['recipe'])?>.php"><?php echo h($curr_row['recipe'])?></a></td>
       <td><?php echo h($curr_row['tags']) ?></td>
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
