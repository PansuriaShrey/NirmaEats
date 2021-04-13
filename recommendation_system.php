<?php
    // session_start();
    include('db.php');


    //variables
    $maxAverageSpent = 0;

    //----------------------------------Exhaustive restaurant list and Restaurant Type------------------------------------------
    $arr = array();
    $query_resType    = "SELECT * FROM `restaurant`";
    $result_resType = mysqli_query($con, $query_resType);
    $rows = mysqli_num_rows($result_resType);
    if (mysqli_num_rows($result_resType) > 0){
    	// echo "IN";
    	// echo "<table border='1'>";
    	// echo "<tr>";
	    	// echo "<td>"."resId"."</td>";
	    	// echo "<td>"."resType"."</td>";
	    	// echo "<td>"."Beverage"."</td>";
	    	// echo "<td>"."Breakfast"."</td>";
	    	// echo "<td>"."Lunch"."</td>";
	    	// echo "<td>"."Dinner"."</td>";
    while($row = mysqli_fetch_assoc($result_resType)) {

    				$arr[$row["resId"]] = array(
    					"BeverageM"=>0,
    					"Breakfast"=>0,
    					"Lunch"=>0,
    					"Dinner"=>0,
    					//---dishtypes
    					"Dosa"=>0,
    					"Salad"=>0,
    					"Starter"=>0,
    					"Vegetable"=>0,
    					"Soup"=>0,
    					"Snack"=>0,
    					"Bread"=>0,
    					"Noodles"=>0,
    					"Rice & Biryani"=>0,
    					"Pulse"=>0,
    					"Beverage"=>0,
    					"Drink"=>0,
    					"Dessert"=>0,
    					//--totalorders
    					"totalOrders"=>0,
    					//--avg Price
    					"avgDishPrice"=>0,
    					//--reviews
    					"totalStars"=>0,
    					"totalReview"=>0,
    					"avgReview"=>0,
    					"normalisedReview"=>0,
    				);
                	// echo "<tr>";
                	// echo "<td>".$row["resId"]."</td>";
                	// echo "<td>".$row["resType"]."</td>";
                	$Beverage = substr_count($row["resType"],"Beverage");
                	$Breakfast = substr_count($row["resType"],"Breakfast");
                	$Lunch = substr_count($row["resType"],"Lunch");
                	$Dinner = substr_count($row["resType"],"Dinner");
                	// echo "<td>".$Beverage."</td>";
			    	// echo "<td>".$Breakfast."</td>";
			    	// echo "<td>".$Lunch."</td>";
			    	// echo "<td>".$Dinner."</td>";

			    	$arr[$row["resId"]]["BeverageM"] = $Beverage;
			    	$arr[$row["resId"]]["Breakfast"] = $Breakfast;
			    	$arr[$row["resId"]]["Lunch"] = $Lunch;
			    	$arr[$row["resId"]]["Dinner"] = $Dinner;
                	$r[] = 	$row["resId"];
                }
                // echo "</table>";
    }
    else{
    	// echo "Not working";
    }

    //-----------------Count number of orders from all restaurants by dishtype-------------------

    $query_JOIN = "SELECT `bill`.`billId`, `bill`.`resId`, `billDetails`.`dishId`, `dish`.`dishType`, SUM(`billDetails`.`Quantity`) AS `sumDish` FROM `billDetails` LEFT JOIN `bill` ON `billDetails`.`billID` = `bill`.`billID` LEFT JOIN `dish` ON `billDetails`.`dishId` = `dish`.`dishId` GROUP BY `bill`.`resId`, `dish`.`dishType`";
	$result_JOIN = mysqli_query($con, $query_JOIN); 
	$rows = mysqli_num_rows($result_JOIN);
    if (mysqli_num_rows($result_JOIN) > 0){
    	// echo "IN";
    	// echo "<table border='1'>";
    	// echo "<tr>";
                	// echo "<td>"."resId"."</td>";
                	// echo "<td>"."dishType"."</td>";
                	// echo "<td>"."sumDish"."</td>";
    while($row = mysqli_fetch_assoc($result_JOIN)) {
                	// echo "<tr>";
                	// echo "<td>".$row["resId"]."</td>";
                	// echo "<td>".$row["dishType"]."</td>";
                	// echo "<td>".$row["sumDish"]."</td>";
                	$arr[$row["resId"]][$row["dishType"]] = $row["sumDish"];
                }
                // echo "</table>";
    }
    else{
    	// echo "Not working";
    }

    //-----------------Count number of orders from all restaurants by dishtype-------------------

    $query_JOIN_res = "SELECT `bill`.`billId`, `bill`.`resId`, `billDetails`.`dishId`, `dish`.`dishType`, SUM(`billDetails`.`Quantity`) AS `sumDish` FROM `billDetails` LEFT JOIN `bill` ON `billDetails`.`billID` = `bill`.`billID` LEFT JOIN `dish` ON `billDetails`.`dishId` = `dish`.`dishId` GROUP BY `bill`.`resId`";
	$result_JOIN_res = mysqli_query($con, $query_JOIN_res); 
	$rows = mysqli_num_rows($result_JOIN_res);
    if (mysqli_num_rows($result_JOIN_res) > 0){
    	// echo "IN";
    	// echo "<table border='1'>";
    	// echo "<tr>";
                	// echo "<td>"."resId"."</td>";
                	// echo "<td>"."sumDish"."</td>";
    while($row = mysqli_fetch_assoc($result_JOIN_res)) {
                	// echo "<tr>";
                	// echo "<td>".$row["resId"]."</td>";
                	// echo "<td>".$row["sumDish"]."</td>";
                	$arr[$row["resId"]]["totalOrders"] = $row["sumDish"];
                }
                // echo "</table>";
    }
    else{
    	// echo "Not working";
    }

    //-------------------------------------Average Dish Price------------------------------------

    $query_avgDishPrice = "SELECT `resId`, AVG(`dishPrice`) AS `avgDishPrice` FROM `dish` GROUP BY `resId`";
	$result_avgDishPrice = mysqli_query($con, $query_avgDishPrice); 
	$rows = mysqli_num_rows($result_avgDishPrice);
    if (mysqli_num_rows($result_avgDishPrice) > 0){
    	// echo "IN";
    	// echo "<table border='1'>";
    	// echo "<tr>";
                	// echo "<td>"."resId"."</td>";
                	// echo "<td>"."avgDishPrice"."</td>";
    while($row = mysqli_fetch_assoc($result_avgDishPrice)) {
                	// echo "<tr>";
                	// echo "<td>".$row["resId"]."</td>";
                	// echo "<td>".$row["avgDishPrice"]."</td>";
                	$arr[$row["resId"]]["avgDishPrice"] = $row["avgDishPrice"];	
                }
                // echo "</table>";
    }
    else{
    	// echo "Not working";
    }

    //-------------------------------------Average reviews and Total reviews---------------------------------

    $reviewThreshold = 5;
    $query_reviews = "SELECT `resId`, SUM(`reviewDish`.`totalStar`) AS `totalStars`, SUM(`reviewDish`.`totalReview`) AS `totalReview` FROM `reviewDish` LEFT JOIN `dish` ON `reviewDish`.`dishId` = `dish`.`dishId` GROUP BY `dish`.`resId`";
	$result_reviews = mysqli_query($con, $query_reviews); 
	$rows = mysqli_num_rows($result_reviews);
    if (mysqli_num_rows($result_reviews) > 0){
    	// echo "IN";
    	// echo "<table border='1'>";
    	// echo "<tr>";
                	// echo "<td>"."resId"."</td>";
                	// echo "<td>"."totalStars"."</td>";
                	// echo "<td>"."totalReview"."</td>";
    while($row = mysqli_fetch_assoc($result_reviews)) {
                	// echo "<tr>";
                	// echo "<td>".$row["resId"]."</td>";
                	// echo "<td>".$row["totalStars"]."</td>";
                	// echo "<td>".$row["totalReview"]."</td>";
                	$arr[$row["resId"]]["totalStars"] = $row["totalStars"];
                	$arr[$row["resId"]]["totalReview"] = $row["totalReview"];
                	$arr[$row["resId"]]["avgReview"] = $row["totalStars"]/$row["totalReview"];
                	$arr[$row["resId"]]["normalisedReview"] = 0.5*($arr[$row["resId"]]["avgReview"]) + 2.5*(1 - exp(-$row["totalReview"]/$reviewThreshold));

                }
                // echo "</table>";
    }
    else{
    	// echo "Not working";
    }


//----------------------------------------------------------------------------------------------
    // echo "<table border=1>";
    // echo "<tr>";
    // echo "<td>"."resId"."</td>";
    // echo "<td>"."BeverageM"."</td>";
    // echo "<td>"."Breakfast"."</td>";
    // echo "<td>"."Lunch"."</td>";
    // echo "<td>"."Dinner"."</td>";
    // echo "<td>"."Dosa"."</td>";
    // echo "<td>"."Salad"."</td>";
    // echo "<td>"."Starter"."</td>";
    // echo "<td>"."Vegetable"."</td>";
    // echo "<td>"."Soup"."</td>";
    // echo "<td>"."Snack"."</td>";
    // echo "<td>"."Bread"."</td>";
    // echo "<td>"."Noodles"."</td>";
    // echo "<td>"."Rice & Biryani"."</td>";
    // echo "<td>"."Pulse"."</td>";
    // echo "<td>"."Beverage"."</td>";
    // echo "<td>"."Drink"."</td>";
    // echo "<td>"."Dessert"."</td>";
    // echo "<td>"."totalOrders"."</td>";
    // echo "<td>"."avgDishPrice"."</td>";
    // echo "<td>"."totalStars"."</td>";
    // echo "<td>"."totalReview"."</td>";
    // echo "<td>"."avgReview"."</td>";
    // echo "<td>"."normlisedReview"."</td>";
    // echo "</tr>";

    foreach($arr as $x => $val) {
    	// echo "<tr>";
    	// echo "<td>"."$x"."</td>";
		foreach($val as $y => $y_val) {
  			// echo "<td>"."$y_val"."</td>";
		}
		// echo "</tr>";

	}
	// echo "</table>";

	//----------------------------------Exhaustive user list------------------------------------------
    
    $arr_u = array();
    $arr_ur = array();
    $query_userType    = "SELECT * FROM `user`";
    $result_userType = mysqli_query($con, $query_userType);
    $rows = mysqli_num_rows($result_userType);
    if (mysqli_num_rows($result_userType) > 0){
    	// echo "IN";
    	// echo "<table border='1'>";
    	// echo "<tr>";
	    	// echo "<td>"."userId"."</td>";
    while($row = mysqli_fetch_assoc($result_userType)) {
    				//-----array for order percentage
    				$arr_u[$row["userId"]] = array(
    					//---dishtypes
    					"Dosa"=>0,
    					"Salad"=>0,
    					"Starter"=>0,
    					"Vegetable"=>0,
    					"Soup"=>0,
    					"Snack"=>0,
    					"Bread"=>0,
    					"Noodles"=>0,
    					"Rice & Biryani"=>0,
    					"Pulse"=>0,
    					"Beverage"=>0,
    					"Drink"=>0,
    					"Dessert"=>0,
    					"AverageSpent"=>0,
    					
    					//--reviews
    					$res = array_fill_keys(array_keys($arr),0),
    					"TotalOrders" => 0,
    				);

    				//----------array for reviews

    				$arr_ur[$row["userId"]] = array(
    					//---dishtypes
    					"Dosa"=>0,
    					"Salad"=>0,
    					"Starter"=>0,
    					"Vegetable"=>0,
    					"Soup"=>0,
    					"Snack"=>0,
    					"Bread"=>0,
    					"Noodles"=>0,
    					"Rice & Biryani"=>0,
    					"Pulse"=>0,
    					"Beverage"=>0,
    					"Drink"=>0,
    					"Dessert"=>0,
    					
    					//--reviews
    					$res = array_fill_keys(array_keys($arr),0)
    				);
                	// echo "<tr>";
                	// echo "<td>".$row["userId"]."</td>";
                }
                // echo "</table>";
    }
    else{
    	// echo "Not working";
    }

	//----------------------------------------------------Average Dish Price by User------------------------------------------    

    $query_avgDishPriceUser = "SELECT `bill`.`userId`, SUM(`billDetails`.`Quantity`) AS `totalQuantity`, SUM(`bill`.`totalPay`) AS `TotalPay` FROM `billDetails` LEFT JOIN `bill` ON `billDetails`.`billId` = `bill`.`billId` GROUP BY `bill`.`userId`";
	$result_avgDishPriceUser = mysqli_query($con, $query_avgDishPriceUser); 
	$rows = mysqli_num_rows($result_avgDishPriceUser);
    if (mysqli_num_rows($result_avgDishPriceUser) > 0){
    	// echo "IN";
    	// echo "<table border='1'>";
    	// echo "<tr>";
                	// echo "<td>"."userId"."</td>";
                	// echo "<td>"."totalQuantity"."</td>";
                	// echo "<td>"."totalPay"."</td>";
    while($row = mysqli_fetch_assoc($result_avgDishPriceUser)) {
                	// echo "<tr>";
                	// echo "<td>".$row["userId"]."</td>";
                	// echo "<td>".$row["totalQuantity"]."</td>";
                	// echo "<td>".$row["TotalPay"]."</td>";
                	if($row["totalQuantity"]!=0)
                	{
                		$arr_u[$row["userId"]]["AverageSpent"] = ($row["TotalPay"]/$row["totalQuantity"]);
                	}
                	else
                	{
                		$arr_u[$row["userId"]]["AverageSpent"] = 0;
                	}
                	if($arr_u[$row["userId"]]["AverageSpent"] > $maxAverageSpent){
                			$maxAverageSpent = $arr_u[$row["userId"]]["AverageSpent"];
                	}
            		$arr_u[$row["userId"]]["TotalOrders"] = $row["totalQuantity"];
                }
                
                // echo "</table>";

				//----------------------------------               

    $result_avgDishPriceUser1 = mysqli_query($con, $query_avgDishPriceUser); 
    while($row = mysqli_fetch_assoc($result_avgDishPriceUser1)) {
    	if($maxAverageSpent!=0){
    		$arr_u[$row["userId"]]["AverageSpent"] = ($arr_u[$row["userId"]]["AverageSpent"])/($maxAverageSpent);
    	}
    	
    }
}
    else{
    	// echo "Not working";
    }

	//-----------------User Orders By restaurant Type------------------------------------------------------------------

    $query_userRes = "SELECT `userId`, `resId`, COUNT(`resId`) AS `resSum` FROM `bill` GROUP BY `userId`, `resId`";
	$result_userRes = mysqli_query($con, $query_userRes); 
	$rows = mysqli_num_rows($result_userRes);
    if (mysqli_num_rows($result_userRes) > 0){
    	// echo "IN";
    	// echo "<table border='1'>";
    	// echo "<tr>";
                	// echo "<td>"."userId"."</td>";
                	// echo "<td>"."resId"."</td>";
                	// echo "<td>"."resSum"."</td>";
    while($row = mysqli_fetch_assoc($result_userRes)) {
                	// echo "<tr>";
                	// echo "<td>".$row["userId"]."</td>";
                	// echo "<td>".$row["resId"]."</td>";
                	// echo "<td>".$row["resSum"]."</td>";
                	$arr_u[$row["userId"]][0][$row["resId"]] = $row["resSum"];
                	$arr_ur[$row["userId"]][0][$row["resId"]] = $row["resSum"];
                }
                // echo "</table>";
    }
    else{
    	// echo "Not working";
    }

    //-----------------Count number of orders from all users by dishtype-------------------

    $query_uJOIN = "SELECT `bill`.`billId`, `bill`.`userId`, `billDetails`.`dishId`, `dish`.`dishType`, SUM(`billDetails`.`Quantity`) AS `sumDish` FROM `billDetails` LEFT JOIN `bill` ON `billDetails`.`billID` = `bill`.`billID` LEFT JOIN `dish` ON `billDetails`.`dishId` = `dish`.`dishId` GROUP BY `bill`.`userId`, `dish`.`dishType`";
	$result_uJOIN = mysqli_query($con, $query_uJOIN); 
	$rows = mysqli_num_rows($result_uJOIN);
    if (mysqli_num_rows($result_uJOIN) > 0){
    	// echo "IN";
    	// echo "<table border='1'>";
    	// echo "<tr>";
                	// echo "<td>"."userId"."</td>";
                	// echo "<td>"."dishType"."</td>";
                	// echo "<td>"."sumDish"."</td>";
    while($row = mysqli_fetch_assoc($result_uJOIN)) {
                	// echo "<tr>";
                	// echo "<td>".$row["userId"]."</td>";
                	// echo "<td>".$row["dishType"]."</td>";
                	// echo "<td>".$row["sumDish"]."</td>";
                	$arr_u[$row["userId"]][$row["dishType"]] = $row["sumDish"]/$arr_u[$row["userId"]]["TotalOrders"];
                	//// echo $arr[$row["userId"]][$row["dishType"]];
                }
                // echo "</table>";
    }
    else{
    	// echo "Not working";
    }

    //---------------------------------------reviews by user and dish type----------------------------------------------------

    $query_uJOINreview = "SELECT `reviewStash`.`userId`, `dish`.`dishType`, AVG(`reviewStash`.`stars`) AS `avgStars` FROM `reviewStash` LEFT JOIN `dish` ON `reviewStash`.`dishID` = `dish`.`dishID`  GROUP BY `reviewStash`.`userId`, `dish`.`dishType`";
	$result_uJOINreview = mysqli_query($con, $query_uJOINreview); 
	$rows = mysqli_num_rows($result_uJOINreview);
    if (mysqli_num_rows($result_uJOINreview) >= 0){
    	// echo "IN";
    	// echo "<table border='1'>";
    	// echo "<tr>";
                	// echo "<td>"."userId"."</td>";
                	// echo "<td>"."dishType"."</td>";
                	// echo "<td>"."avgStars"."</td>";
    while($row = mysqli_fetch_assoc($result_uJOINreview)) {
                	// echo "<tr>";
                	// echo "<td>".$row["userId"]."</td>";
                	// echo "<td>".$row["dishType"]."</td>";
                	// echo "<td>".$row["avgStars"]."</td>";
                	$arr_ur[$row["userId"]][$row["dishType"]] = $row["avgStars"];
                	//// echo $arr[$row["userId"]][$row["dishType"]];
                }
                // echo "</table>";
    }
    else{
    	// echo "Not working";
    }

    //------------------------------------------------------------------------------------------------

    // echo "<table border=1>";
    // echo "<tr>";
    // echo "<td>"."userId"."</td>";
    // echo "<td>"."Dosa"."</td>";
    // echo "<td>"."Salad"."</td>";
    // echo "<td>"."Starter"."</td>";
    // echo "<td>"."Vegetable"."</td>";
    // echo "<td>"."Soup"."</td>";
    // echo "<td>"."Snack"."</td>";
    // echo "<td>"."Bread"."</td>";
    // echo "<td>"."Noodles"."</td>";
    // echo "<td>"."Rice & Biryani"."</td>";
    // echo "<td>"."Pulse"."</td>";
    // echo "<td>"."Beverage"."</td>";
    // echo "<td>"."Drink"."</td>";
    // echo "<td>"."Dessert"."</td>";
    // echo "<td>"."AverageSpent"."</td>";


    foreach($arr_u[1][0] as $x => $val){
    	// echo "<td>"."resId = "."$x"."</td>";
    }
    // echo "<td>"."TotalOrders"."</td>";
    foreach($arr_u as $x => $val) {
    	// echo "<tr>";
    	// echo "<td>"."$x"."</td>";
		foreach($val as $y => $y_val) {
			if(gettype($y_val)!="array"){
				// echo "<td>"."$y_val"."</td>";
			}
			else
			{
				foreach($y_val as $y_val_x => $y_val_value)
				{
					// echo "<td>"."$y_val_value"."</td>";
				}
			}
  			
		}
		// echo "</tr>";

	}
	// echo "</table>";

	//------------------------------------------------------------------------------------------------

    // echo "<table border=1>";
    // echo "<tr>";
    // echo "<td>"."userId"."</td>";
    // echo "<td>"."Dosa"."</td>";
    // echo "<td>"."Salad"."</td>";
    // echo "<td>"."Starter"."</td>";
    // echo "<td>"."Vegetable"."</td>";
    // echo "<td>"."Soup"."</td>";
    // echo "<td>"."Snack"."</td>";
    // echo "<td>"."Bread"."</td>";
    // echo "<td>"."Noodles"."</td>";
    // echo "<td>"."Rice & Biryani"."</td>";
    // echo "<td>"."Pulse"."</td>";
    // echo "<td>"."Beverage"."</td>";
    // echo "<td>"."Drink"."</td>";
    // echo "<td>"."Dessert"."</td>";


    foreach($arr_ur[1][0] as $x => $val){
    	// echo "<td>"."resId = "."$x"."</td>";
    }
    foreach($arr_ur as $x => $val) {
    	// echo "<tr>";
    	// echo "<td>"."$x"."</td>";
		foreach($val as $y => $y_val) {
			if(gettype($y_val)!="array"){
				// echo "<td>"."$y_val"."</td>";
			}
			else
			{
				foreach($y_val as $y_val_x => $y_val_value)
				{
					// echo "<td>"."$y_val_value"."</td>";
				}
			}
  			
		}
		// echo "</tr>";

	}
	// echo "</table>";

	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function KNN($arr_u,$userId,$k){
		$distances = array();
		foreach($arr_u as $x => $val) {
			if($x!=$userId){
				$dist = 0;
				$count = 0;
				foreach($val as $y => $y_val) {
					$count = $count+1;
					if(gettype($y_val)!="array"){
						$dist = $dist + ($arr_u[$userId][$y]-$y_val)**2;
					}
					else if(gettype($y_val)=="array"){
						break;
					}
					else{
						break;
					}
  			
				}
				$dist = $dist/$count;
				$dist = $dist**(1/2);
				//// echo $dist;
				//// echo "<br>";
				$distances[$x] = $dist;
			}

		}
		asort($distances);
        return $distances;
	}

    $k = 3;
    $userId = 5;
    if(isset($_SESSION["userid"])){
        // echo $userId;
        $userId = $_SESSION["userid"];
    }
    // echo $userId;
    $recommended_restaurants = array();

    if($arr_u[$userId]["TotalOrders"]<10){
        // $recommended_restaurants = array();
        foreach($arr as $x => $x_val){
            $recommended_restaurants[$x] = $arr[$x]["normalisedReview"];
        }
        arsort($recommended_restaurants);
        $recommended_restaurants = array_keys($recommended_restaurants);
        // print_r($recommended_restaurants);
        
    }
    else{

        $distances_1 = KNN($arr_u,$userId,$k);
        /*foreach($distances_1 as $x => $x_val){
                // echo $x;
                // echo "<br>";
            }*/
        $count = 0;
        $answer = array();
        foreach($distances_1 as $x => $x_val){
            if($count >= $k){
                break;
            }
            foreach($arr_u[$x][0] as $y => $y_val){
                if(!array_key_exists($y,$answer))
                {
                    $answer[$y] = $y_val;
                }
                else
                {
                    $answer[$y] = $answer[$y] + $y_val;
                }
                
            }
                $count = $count + 1;
        }
        /*// echo "<br>";
        foreach($answer as $x => $x_val){
            // echo $x."->".$x_val;
            // echo "<br>";
        }*/
        

        $distances_2 = KNN($arr_ur,$userId,$k);
        /*foreach($distances_2 as $x => $x_val){
                // echo $x;
                // echo "<br>";
            }*/
        $count = 0;
        foreach($distances_2 as $x => $x_val){
            if($count >= $k){
                break;
            }
            foreach($arr_ur[$x][0] as $y => $y_val){
                if($answer[$y]==NULL)
                {
                    $answer[$y] = $y_val;
                }
                else
                {
                    $answer[$y] = $answer[$y] + $y_val;
                }
            }
            $count = $count + 1;
        }

        arsort($answer);
       
        /*// echo "<br>";
    	foreach($answer as $x => $x_val){
    		// echo $x."->".$x_val;
    		// echo "<br>";
    	}*/

        $recommended_restaurants = array_keys($answer);
        // print_r($recommended_restaurants);
    }
?>