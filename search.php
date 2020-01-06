<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css"
</head>

<body>
<?php include('header.php'); ?>

<h2 class="form_title">Find Recipe</h2>
<div id="search_form">
    <form action="" method="get">
        <div class="input_h">
        <p>Serves at least:</p>
        <input type="number" name="servings" min="0" max="72" />
        </div>
        <br>
        <div class="input_h">
            <p>Search</p>
            <input type="search" name="search" value="Enter Here" />
        </div>
        <br>
        <div class="input_h">
            <p>Submit</p>
            <input type="submit" name="submit_form"value="Submit" />
        </div>
        <br>
    </form>
</div>







</body>
</html>
