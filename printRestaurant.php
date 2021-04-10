<?php

    function printRestaurant($result){
        $count=mysqli_num_rows($result);
        if($count==0){
            echo "
                <center>
                    <div class='container '>
                        <p> No Restaurant present </p>
                    </div>
                </center>
            ";
            return;
        }
        $i=0;
        echo "<center>
            <div>
        ";
        while($row = mysqli_fetch_assoc($result)){
            $rid=$row["resId"];
            $rname=$row["resName"];
            $remail=$row["resEmailId"];
            $raddress=$row["resAddress"];
            $rtype=$row["resType"];
            $rpic=$row["resPicture"];
            $rot=$row["resOpeningTime"];
            $rct=$row["resClosingTime"];
            // echo $rname." ".$rpic;
            // echo "<center>
            //     <section id='testimonials' class='testimonials' style='width: 65%; margin: 2%;'>
            //     <div class='container'>

            //     <div class='testimonials-slider swiper-container'>
            //     <div class='swiper-wrapper'>

            //         <div class='swiper-slide'>
            //         <div class='testimonial-wrap'>
            //             <div class='testimonial-item bg-light'>
            //             <img src='assets/images/$rpic' width='200' height='200' class='testimonial-img' alt=''>
            //             <h3>$rname</h3>
            //             <h4 class='text-danger'>Email : $remail</h4>
            //             <h4>Address : $raddress</h4>
            //             <p>
            //                 Restaurant Type : $rtype<br>
            //                 Restaurant Opening Time : $rot <br>
            //                 Restaurant Closing Time :  $rct
            //             </p>
            //             </div>
            //         </div>
            //         </div>
            //     </div>
            //     </div>
            //     </div>
            //     </section><!-- End Section -->
            //     </center>";
            $i++;
            if($i%2==1){
                echo "
                    </div>
                    <div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 d-flex justify-content-center'>
                ";
            }
            echo "
                <div class='col mb-4 ' style='margin:2%; max-width: 30%;'>
                    <div class='card w-100 h-100'>
                        <img src='assets/images/$rpic' width='250' height='250' class='card-img-top img2' alt='...'>
                        <div class='card-body table-responsive'>
                                <table class='table table-light w-auto'>
                                    <thead style='text-align: center;'>
                                        <tr>
                                            <th colspan=2>
                                                <a href='restaurant_dishes.php?resid=$rid&dishid=0' onclick=''>
                                                    $rname
                                                </a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Email</td>
                                            <td>$remail</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>$raddress</td>
                                        </tr>
                                        <tr>
                                            <td>Timing</td>
                                            <td>From $rot to $rct</td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            ";
        }
        echo "
            </div>
            </center>
        ";
    }

?>