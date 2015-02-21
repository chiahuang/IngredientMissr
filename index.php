<!doctype html>
<html>
<body>
<head>

Ingredients: <?php 

	echo "<br> Working <br>";
	$ingredients = $_GET["ingredient"];
	$listOfIngredient = explode(", ", $ingredients);
	//$maxSizeofIngredients = sizeof($listOfIngredient);
	$key = null;
	
	// Begin Searching
	
	$search = "http://food2fork.com/api/search?key=802d345a1d314c436dd06583ee5bd491&q=";
	$searchValues = null;
	foreach($listOfIngredient as $value)
	{
		$searchValues .= $value ."%20";
		//echo $_GET["ingredient"]; 
		
	}
	$search .= $searchValues;
	$jsonSearchContent = file_get_contents($search);
	echo "$jsonSearchContent";

	echo "<br>";
	
	$jfo = json_decode($jsonSearchContent);	
	//echo "$jfo";
	echo "<br>";
	$totalRecipesCount = $jfo->count;
	echo "<br> $totalRecipesCount <br>";
	
	$listOfRecipes = $jfo->recipes;
	
	$listOfRecipesId = array();
	$listOfRecipesTitle = array();
	$listOfRecipesImage = array();
	$max = sizeof($listOfRecipes);
	for($i=0; $i<$max ;$i++)
	{
		array_push($listOfRecipesId, $listOfRecipes[$i]->recipe_id);
		array_push($listOfRecipesTitle, $listOfRecipes[$i]->title);
		array_push($listOfRecipesImage, $listOfRecipes[$i]->image_url);
	}
	
	echo "<br> $search <br>";
	// End of searching
	
	// Begin Getting ingredients
	$key = $listOfRecipesId[0];
	echo "<br> $key <br>";
	$get = "http://food2fork.com/api/get?key=802d345a1d314c436dd06583ee5bd491&rId={$key}";
	echo "<br>";
	echo "$get <br> <br>";
	
	$jsonGetContent = file_get_contents($get);
	echo "$jsonGetContent <br><br>";
	
	$jgfo = json_decode($jsonGetContent);
	echo "<br>";
	
	$jsonArrayOfIngredients = $jgfo->recipe->ingredients;
	echo "bs";
	echo "<br> $jsonArrayOfIngredients <br>";
	echo "<br> $maxSizeofIngredients <br>";
	foreach($listOfIngredient as $ingredient)
	{
		for($j=0; $j<sizeof($jsonArrayOfIngredients);$j++)
		{
			if(strpos($jsonArrayOfIngredients[$j],$ingredient) !== false)
			{
				unset($jsonArrayOfIngredients[$j]);
				
				echo "$ingredient gg<br>";
			}
			else
			{
				//echo "$listOfIngredient[$j] <br>";
				echo "$jsonArrayOfIngredients[$j] dd<br>";
			}
		}
	}
	echo "<br> <br>";
	$jsonArrayOfIngredients = array_values($jsonArrayOfIngredients);
	foreach($jsonArrayOfIngredients as $values)
	{
		echo "$values <br>";
	}
	
?>

<br>
	

<a  href="index.html" > Return to homepage </a>
<head>
</body>
</html>