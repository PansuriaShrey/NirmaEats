<?php
    $con = mysqli_connect("localhost","root","","nirmaeats");
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    echo "Connected Successfully";

    //----------------------------------Exhaustive restaurant list and Restaurant Type------------------------------------------
    $arr = array();
    $query_resType    = "SELECT * FROM `restaurant`";
    $result_resType = mysqli_query($con, $query_resType);
    $rows = mysqli_num_rows($result_resType);
    if (mysqli_num_rows($result_resType) > 0){
    	echo "IN";
    	echo "<table border='1'>";
    	echo "<tr>";
	    	echo "<td>"."resId"."</td>";
	    	echo "<td>"."resType"."</td>";
	    	echo "<td>"."Beverage"."</td>";
	    	echo "<td>"."Breakfast"."</td>";
	    	echo "<td>"."Lunch"."</td>";
	    	echo "<td>"."Dinner"."</td>";
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
    					//--avg Price
    					"avgDishPrice"=>0,
    					//--reviews
    					"totalStars"=>0,

    					"totalReview"=>0,
    					"avgReview"=>0,
    				);
                	echo "<tr>";
                	echo "<td>".$row["resId"]."</td>";
                	echo "<td>".$row["resType"]."</td>";
                	$Beverage = substr_count($row["resType"],"Beverage");
                	$Breakfast = substr_count($row["resType"],"Breakfast");
                	$Lunch = substr_count($row["resType"],"Lunch");
                	$Dinner = substr_count($row["resType"],"Dinner");
                	echo "<td>".$Beverage."</td>";
			    	echo "<td>".$Breakfast."</td>";
			    	echo "<td>".$Lunch."</td>";
			    	echo "<td>".$Dinner."</td>";

			    	$arr[$row["resId"]]["BeverageM"] = $Beverage;
			    	$arr[$row["resId"]]["Breakfast"] = $Breakfast;
			    	$arr[$row["resId"]]["Lunch"] = $Lunch;
			    	$arr[$row["resId"]]["Dinner"] = $Dinner;
                	$r[] = 	$row["resId"];
                }
                echo "</table>";
    }
    else{
    	echo "Not working";
    }

    //-----------------Count number of orders from all restaurants by dishtype-------------------

    $query_JOIN = "SELECT `bill`.`billId`, `bill`.`resId`, `billDetails`.`dishId`, `dish`.`dishType`, COUNT(`dish`.`dishType`) AS `sumDish` FROM `billDetails` LEFT JOIN `bill` ON `billDetails`.`billID` = `bill`.`billID` LEFT JOIN `dish` ON `billDetails`.`dishId` = `dish`.`dishId` GROUP BY `bill`.`resId`, `dish`.`dishType`";
	$result_JOIN = mysqli_query($con, $query_JOIN); 
	$rows = mysqli_num_rows($result_JOIN);
    if (mysqli_num_rows($result_JOIN) > 0){
    	echo "IN";
    	echo "<table border='1'>";
    	echo "<tr>";
                	echo "<td>"."resId"."</td>";
                	echo "<td>"."dishType"."</td>";
                	echo "<td>"."sumDish"."</td>";
    while($row = mysqli_fetch_assoc($result_JOIN)) {
                	echo "<tr>";
                	echo "<td>".$row["resId"]."</td>";
                	echo "<td>".$row["dishType"]."</td>";
                	echo "<td>".$row["sumDish"]."</td>";
                	$arr[$row["resId"]][$row["dishType"]] = $row["sumDish"];
                }
                echo "</table>";
    }
    else{
    	echo "Not working";
    }

    //-------------------------------------Average Dish Price------------------------------------

    $query_avgDishPrice = "SELECT `resId`, AVG(`dishPrice`) AS `avgDishPrice` FROM `dish` GROUP BY `resId`";
	$result_avgDishPrice = mysqli_query($con, $query_avgDishPrice); 
	$rows = mysqli_num_rows($result_avgDishPrice);
    if (mysqli_num_rows($result_avgDishPrice) > 0){
    	echo "IN";
    	echo "<table border='1'>";
    	echo "<tr>";
                	echo "<td>"."resId"."</td>";
                	echo "<td>"."avgDishPrice"."</td>";
    while($row = mysqli_fetch_assoc($result_avgDishPrice)) {
                	echo "<tr>";
                	echo "<td>".$row["resId"]."</td>";
                	echo "<td>".$row["avgDishPrice"]."</td>";
                	$arr[$row["resId"]]["avgDishPrice"] = $row["avgDishPrice"];	
                }
                echo "</table>";
    }
    else{
    	echo "Not working";
    }

    //-------------------------------------Average reviews and Total reviews---------------------------------

    $query_reviews = "SELECT `resId`, SUM(`reviewDish`.`totalStar`) AS `totalStars`, SUM(`reviewDish`.`totalReview`) AS `totalReview` FROM `reviewDish` LEFT JOIN `dish` ON `reviewDish`.`dishId` = `dish`.`dishId` GROUP BY `dish`.`resId`";
	$result_reviews = mysqli_query($con, $query_reviews); 
	$rows = mysqli_num_rows($result_reviews);
    if (mysqli_num_rows($result_reviews) > 0){
    	echo "IN";
    	echo "<table border='1'>";
    	echo "<tr>";
                	echo "<td>"."resId"."</td>";
                	echo "<td>"."totalStars"."</td>";
                	echo "<td>"."totalReview"."</td>";
    while($row = mysqli_fetch_assoc($result_reviews)) {
                	echo "<tr>";
                	echo "<td>".$row["resId"]."</td>";
                	echo "<td>".$row["totalStars"]."</td>";
                	echo "<td>".$row["totalReview"]."</td>";
                	$arr[$row["resId"]]["totalStars"] = $row["totalStars"];
                	$arr[$row["resId"]]["totalReview"] = $row["totalReview"];
                	$arr[$row["resId"]]["avgReview"] = $row["totalStars"]/$row["totalReview"];

                }
                echo "</table>";
    }
    else{
    	echo "Not working";
    }
//----------------------------------------------------------------------------------------------
    echo "<table border=1>";
    echo "<tr>";
    echo "<td>"."resId"."</td>";
    echo "<td>"."BeverageM"."</td>";
    echo "<td>"."Breakfast"."</td>";
    echo "<td>"."Lunch"."</td>";
    echo "<td>"."Dinner"."</td>";
    echo "<td>"."Dosa"."</td>";
    echo "<td>"."Salad"."</td>";
    echo "<td>"."Starter"."</td>";
    echo "<td>"."Vegetable"."</td>";
    echo "<td>"."Soup"."</td>";
    echo "<td>"."Snack"."</td>";
    echo "<td>"."Bread"."</td>";
    echo "<td>"."Noodles"."</td>";
    echo "<td>"."Rice & Biryani"."</td>";
    echo "<td>"."Pulse"."</td>";
    echo "<td>"."Beverage"."</td>";
    echo "<td>"."Drink"."</td>";
    echo "<td>"."Dessert"."</td>";
    echo "<td>"."avgDishPrice"."</td>";
    echo "<td>"."totalStars"."</td>";
    echo "<td>"."totalReview"."</td>";
    echo "<td>"."avgReview"."</td>";
    echo "</tr>";

    foreach($arr as $x => $val) {
    	echo "<tr>";
    	echo "<td>"."$x"."</td>";
		foreach($val as $y => $y_val) {
  			echo "<td>"."$y_val"."</td>";
		}
		echo "</tr>";

	}
	echo "</table>";

	//----------------------------------Exhaustive restaurant list and Restaurant Type------------------------------------------
    
    $arr_u = array();
    $query_userType    = "SELECT * FROM `user`";
    $result_userType = mysqli_query($con, $query_userType);
    $rows = mysqli_num_rows($result_userType);
    if (mysqli_num_rows($result_userType) > 0){
    	echo "IN";
    	echo "<table border='1'>";
    	echo "<tr>";
	    	echo "<td>"."userId"."</td>";
    while($row = mysqli_fetch_assoc($result_userType)) {

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
    					$res = array_fill_keys(array_keys($arr),0)
    				);
                	echo "<tr>";
                	echo "<td>".$row["userId"]."</td>";
                }
                echo "</table>";
    }
    else{
    	echo "Not working";
    }

	//-----------------User Orders By restaurant Type-------------------

    $query_userRes = "SELECT `userId`, `resId`, COUNT(`resId`) AS `resSum` FROM `bill` GROUP BY `userId`, `resId`";
	$result_userRes = mysqli_query($con, $query_userRes); 
	$rows = mysqli_num_rows($result_userRes);
    if (mysqli_num_rows($result_userRes) > 0){
    	echo "IN";
    	echo "<table border='1'>";
    	echo "<tr>";
                	echo "<td>"."userId"."</td>";
                	echo "<td>"."resId"."</td>";
                	echo "<td>"."resSum"."</td>";
    while($row = mysqli_fetch_assoc($result_userRes)) {
                	echo "<tr>";
                	echo "<td>".$row["userId"]."</td>";
                	echo "<td>".$row["resId"]."</td>";
                	echo "<td>".$row["resSum"]."</td>";
                	$arr_u[$row["userId"]][0][$row["resId"]] = $row["resSum"];
                }
                echo "</table>";
    }
    else{
    	echo "Not working";
    }

    //-----------------Count number of orders from all users by dishtype-------------------

    $query_uJOIN = "SELECT `bill`.`billId`, `bill`.`userId`, `billDetails`.`dishId`, `dish`.`dishType`, COUNT(`dish`.`dishType`) AS `sumDish` FROM `billDetails` LEFT JOIN `bill` ON `billDetails`.`billID` = `bill`.`billID` LEFT JOIN `dish` ON `billDetails`.`dishId` = `dish`.`dishId` GROUP BY `bill`.`userId`, `dish`.`dishType`";
	$result_uJOIN = mysqli_query($con, $query_uJOIN); 
	$rows = mysqli_num_rows($result_uJOIN);
    if (mysqli_num_rows($result_uJOIN) > 0){
    	echo "IN";
    	echo "<table border='1'>";
    	echo "<tr>";
                	echo "<td>"."userId"."</td>";
                	echo "<td>"."dishType"."</td>";
                	echo "<td>"."sumDish"."</td>";
    while($row = mysqli_fetch_assoc($result_uJOIN)) {
                	echo "<tr>";
                	echo "<td>".$row["userId"]."</td>";
                	echo "<td>".$row["dishType"]."</td>";
                	echo "<td>".$row["sumDish"]."</td>";
                	$arr_u[$row["userId"]][$row["dishType"]] = $row["sumDish"];
                	//echo $arr[$row["userId"]][$row["dishType"]];
                }
                echo "</table>";
    }
    else{
    	echo "Not working";
    }

    //-------------------------------------------------------------------------------------------

    $query_avgDishPriceUser = "SELECT `bill`.`userId`, SUM(`billDetails`.`Quantity`) AS `totalQuantity`, SUM(`bill`.`totalPay`) AS `TotalPay` FROM `billDetails` LEFT JOIN `bill` ON `billDetails`.`billId` = `bill`.`billId` GROUP BY `bill`.`userId`";
	$result_avgDishPriceUser = mysqli_query($con, $query_avgDishPriceUser); 
	$rows = mysqli_num_rows($result_avgDishPriceUser);
    if (mysqli_num_rows($result_avgDishPriceUser) > 0){
    	echo "IN";
    	echo "<table border='1'>";
    	echo "<tr>";
                	echo "<td>"."userId"."</td>";
                	echo "<td>"."totalQuantity"."</td>";
                	echo "<td>"."totalPay"."</td>";
    while($row = mysqli_fetch_assoc($result_avgDishPriceUser)) {
                	echo "<tr>";
                	echo "<td>".$row["userId"]."</td>";
                	echo "<td>".$row["totalQuantity"]."</td>";
                	echo "<td>".$row["TotalPay"]."</td>";
                	if($row["totalQuantity"]!=0)
                	{
                		$arr_u[$row["userId"]]["AverageSpent"] = ($row["TotalPay"]/$row["totalQuantity"]);
                	}
                	else
                	{
                		$arr_u[$row["userId"]]["AverageSpent"] = 0;
                	}
                		
                }
                echo "</table>";
    }
    else{
    	echo "Not working";
    }

    //----------------------------------------

    echo "<table border=1>";
    echo "<tr>";
    echo "<td>"."userId"."</td>";
    echo "<td>"."Dosa"."</td>";
    echo "<td>"."Salad"."</td>";
    echo "<td>"."Starter"."</td>";
    echo "<td>"."Vegetable"."</td>";
    echo "<td>"."Soup"."</td>";
    echo "<td>"."Snack"."</td>";
    echo "<td>"."Bread"."</td>";
    echo "<td>"."Noodles"."</td>";
    echo "<td>"."Rice & Biryani"."</td>";
    echo "<td>"."Pulse"."</td>";
    echo "<td>"."Beverage"."</td>";
    echo "<td>"."Drink"."</td>";
    echo "<td>"."Dessert"."</td>";
    echo "<td>"."AverageSpent"."</td>";

    foreach($arr_u[1][0] as $x => $val){
    	echo "<td>"."resId = "."$x"."</td>";
    }
    foreach($arr_u as $x => $val) {
    	echo "<tr>";
    	echo "<td>"."$x"."</td>";
		foreach($val as $y => $y_val) {
			if(gettype($y_val)!="array"){
				echo "<td>"."$y_val"."</td>";
			}
			else
			{
				foreach($y_val as $y_val_x => $y_val_value)
				{
					echo "<td>"."$y_val_value"."</td>";
				}
			}
  			
		}
		echo "</tr>";

	}
	echo "</table>";
		

?>