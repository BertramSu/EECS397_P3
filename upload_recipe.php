<?php 

echo $_POST["recipe_name"];
echo " submitted succesfully";

$current_data = file_get_contents('db-recipes.json');
$array_data = json_decode($current_data, true);
$array_data[] = recipeArray();
file_put_contents('test.json', json_encode($array_data));

function recipeArray(){
	return array(
			'id' => '',
			'name' => $_POST["recipe_name"], 
			'preptime' => $_POST["prep_time"], 
			'servings' => $_POST["servings"],
			'calories' => $_POST["calories"],
			'instructions' => $_POST["instructions"],
			'ingredients' => ingredientsArray()
		);
}

function ingredientsArray(){
	$ingredients = $_POST["ingredients"];
	$ingredients_array = [];

	foreach ($ingredients as $ingredient) {

		if (!empty($ingredient)){
			array_push($ingredients_array, $ingredient);
		}

	}

	return $ingredients_array;
}


?>

