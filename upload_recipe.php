<?php 

validateCAPTCHA();
$recipes_db = 'db-recipes.json';
$current_data = file_get_contents($recipes_db);
$data_array = json_decode($current_data, true);
$data_array[] = recipeArray();
file_put_contents($recipes_db, json_encode($data_array));

# Server response
echo json_encode(array('success' => 1));


## HELPER FUNCTIONS 

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

function validateCAPTCHA(){

	if (isset($_POST['g-recaptcha-response']) ){
		$captcha=$_POST['g-recaptcha-response'];
    }

    if (!$captcha){
        echo json_encode(array('success' => 0));
        exit;
    }

    $secretKey = "6LeJxu4UAAAAAE14zNWcMKI0SM0LGGJeAx_Xbb0q";
    $ip = $_SERVER['REMOTE_ADDR'];
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        echo json_encode(array('success' => 0));
        exit;
    }
}

?>

