<html>
<body>
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Blog Template for Bootstrap</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <!-- Bootstrap core CSS -->
      <link href="" rel="stylesheet">

      <!-- Custom styles for this template -->
      <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
      <link href="recipe.css" rel="stylesheet">

<?php
    $id = $_POST["recipe_id"];
    $image_source = $_POST["img_src"];
    $current_data = file_get_contents('db-recipes.json');
		$recipes = json_decode($current_data, true);
    $recipe = $recipes[$id];

    // function recipe_image_source($recipe){
    //   $google_api_info = json_decode(file_get_contents('googleapi.json'), true);
    //   $API_KEY = $google_api_info["API_KEY"];
    //   $GOOGLE_CX = $google_api_info["GOOGLE_CX"];
    //   $query = str_replace(' ','+',$recipe['name']);
    //   $json = file_get_contents('https://www.googleapis.com/customsearch/v1?q='.$query.'&key='.$API_KEY."&cx=".$GOOGLE_CX.'&searchType=image');
    //   $data = json_decode($json, true);
    //   $result_image_source = $data['items'][0]['link'];
    //   echo '<img src="'.$result_image_source.'">';
    // }
?>
<main role="main" class="container">
      <div class="row">
        <div class="col-md-8 blog-main">
          <div class="blog-post">
            <h2 class="blog-post-title"><?php echo $recipe['name'] ?></h2>
          </div><!-- /.blog-post -->
          <div id='container' class="blog-post-title">
            <?php
              echo '<img src="'.$image_source.'">';
            ?>
          </div>
          <div class="blog-post">
            <h4>Nutrition</h4>
            <ul>
              <li>Calories: <?php echo $recipe["calories"]?></li>
              <li>Fat: <?php echo $recipe["fat"]?></li>
              <li>Carbs: <?php echo $recipe["carbs"]?></li>
              <li>Protein: <?php echo $recipe["protein"]?></li>
            </ul>
            <h4>Ingredients</h4>
            <ul>
              <?php
                foreach($recipe['ingredients'] as $ingredient){
                  echo '<li>'.$ingredient.'</li>';
                }
               ?>
            </ul>
            <h4>Instructions</h4>
            <p> <?php echo $recipe['instructions'] ?> </p>
          </div><!-- /.blog-post -->
        </div><!-- /.blog-main -->
</main>

</body>
</html>
