<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<?php include('header.php'); ?>

<div style="text-align: center;">
  <h1>Recipe Database</h1>

  <h2>Newest Recipes</h2>
  <table style="margin: 0 auto;">
    <?php
    //loop as long as there are more elements to display:
    $table_output = "
    <tr class=\"table_header\">
      <td>Recipe </td>
      <td>Tags </td>
      <td>Serves </td>
      <td>Date Added</td>
    </tr>
    ";

    echo $table_output;
    ?>
    <?php
    //while there are more elements to display:
    //create parts of the html string and combine them together to form a complete row
    //echo the row and repeat the process with new elements
    $host = 'localhost';
    $user = 'webuser';
    $password = 'password';
    $database = 'recipes';
    $sql_connection = mysqli_connect($host,$user,$password,$database);

    $query = 'SELECT * FROM subjects ';
    $query .= 'ORDER BY date ASC';
    $content = mysqli_query($sql_connection,$query);

    $recipe_count = mysqli_num_rows($content);

    for($i = 0; $i < $recipe_count; $i++){
      $curr_row = $mysqli_fetch_assoc($content);

      $recipe_name = $curr_row['recipe']; //get from sql database
      $recipe_tags = $curr_row['tags']; //get from sql database
      $recipe_servings = $curr_row['servings']; // get from sql database
      $recipe_date = $curr_row['date'];


      //This area can be redone for readability
      $recipe_name_cell = '<td><a href=' . '"' . $recipe_name . '.php">' . $recipe_name . '</a></td>';
      $recipe_tags_cell = '<td>' . $recipe_tags . '</td>';
      $recipe_servings_cell = '<td>' . $recipe_servings . '</td>';
      $recipe_date_cell = '<td>' . $recipe_date . '</td>';

      echo "<tr class=\"home_table_row\">" . $recipe_name_cell . $recipe_tags_cell . $recipe_servings_cell . $recipe_date_cell . "</tr>";
    }

    mysqli_free_result($content);
    mysqli_close($sql_connection);
     ?>
  </table>
</div>
