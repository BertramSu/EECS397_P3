<html>
	<head>
	    <meta charset="UTF-8">
	    <title>Search Result</title>

	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	    <style>
	        body {
	            background: #fafafa;
	            color: #333333;
	            margin-top: 1%;
	            margin-left: 1%;
	            margin-bottom: 2%;
	        }

	        img {
							object-fit: cover;
	        }
	    </style>
	</head>
	<body>


		<?php

		$current_data = file_get_contents('db-recipes.json');
		$recipes = json_decode($current_data, true);
		$matching_recipes = matching_recipes($recipes);
		if(count($matching_recipes) == 0){
			echo '<h1 class="text-info">Sorry there was no match :((</h1>';
			echo '<div class="text-center"><img src="https://pbs.twimg.com/profile_images/1042019157972320256/STolLU9B_400x400.jpg" class="rounded"></div>';
		}
		else{
			echo '<h1 class="text-info">Here\'s what we found :))</h1>';
			echo "<div class=\"d-flex flex-wrap\">";
			foreach($matching_recipes as $recipe){
				display_recipe($recipe);
			}
			echo "</div>";
		}

		function recipe_image_source($recipe){
      $google_api_info = json_decode(file_get_contents('googleapi.json'), true);
      $API_KEY = $google_api_info["API_KEY"];
      $GOOGLE_CX = $google_api_info["GOOGLE_CX"];
      $query = str_replace(' ','+',$recipe['name']);
      $json = file_get_contents('https://www.googleapis.com/customsearch/v1?q='.$query.'&key='.$API_KEY."&cx=".$GOOGLE_CX.'&searchType=image');
      $data = json_decode($json, true);
      $result_image_source = $data['items'][0]['link'];
      echo '<img class="card-img-top" src="'.$result_image_source.'">';
    }

		function display_recipe($recipe){
				echo '<div class="card" style="width: 18rem;">';
				recipe_image_source($recipe);
				echo '<div class="card-body">';
				echo '<h5 class="card-title">'.$recipe["name"].'</h5>';
				echo '<p class="card-text">'.$recipe["source"].'</p>';
				echo '<form action="view_recipe.php"  method="post" id="view-recipe">';
				echo '<input type="hidden" id="recipe_id" name="recipe_id" value='.$recipe['id'].'>';
				echo '<input type="submit" class="btn btn-primary" value="See more">';
				echo '</form>';
				echo '</div>';
				echo '</div>';
		}

		function matching_recipes($recipes){
			$offset = $_GET['offset'];
			$items = $_GET['items'];
			$matching_recipes = array();
			foreach($recipes as $id => $recipe){
		  	$ingridients = $recipe['ingredients'];
				$keywords = preg_split("/[\s,]+/", $items);
				$match = matches($ingridients, $keywords);
				if(abs($match - count($keywords)) < $offset and $match > 0){
					$matching_recipes[$id] = $recipe;
				}
		  }
			return $matching_recipes;
		}

		function items_array($item){

		}

		function matches($ingridients, $keywords){
			$match = 0;
			foreach($ingridients as $ingredient){
				foreach($keywords as $keyword){
					// print('ing<br>');
					// print($ingredient);
					// print('<br>');
					// print('key<br>');
					// print($keyword);
				  // print('<br>');
					if(preg_match('/\b'.$keyword.'\b/i', $ingredient)){
						// print($ingredient);
						$match++;
					}
				}
			}
			return $match;
		}
		?>
	</body>
	<script>
	$(document).ready(function() {
		$('#view-recipe').on('submit', function(e){
				e.preventDefault();
		});
	});
	</script>
</html>
