<!DOCTYPE html>
<?php
session_start();
    require_once ('../Controllers/navController.php');
    require_once ('../Controllers/detailController.php');
    require_once ('../Controllers/loginController.php');
    require_once ('../Controllers/cartController.php');


   if(isset($_POST['login-button'])){
         loginRequest();
   }

    if(isset($_POST['cart-button'])){
          cartRequest();
    }

    if(isset($_POST['activities-button'])){
        activitiesRequest();
    }

    if(isset($_POST['hotel-button'])){
        hotelsRequest();
    }

    if(isset($_POST['flight-button'])){
        flightRequest();
    }

    
if(isset($_POST['logout'])){
    logout();
}

if(isset($_POST['addtocart'])){

    $_SESSION['tourduration'] = $_POST['duration'];
    if (!isset($_SESSION['email'])) {
        echo "User is not logged in!";
        exit();
       
    }
    $email = $_SESSION['email'];
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productImage = $_POST['productImage'];
    if(addToCartController($email,$productName, $productPrice, $productImage)){
        echo "Product added to cart";
    }
    else{
        echo "Product not added to cart";
    }
}

if(isset($_POST['btn-product-book'])){
    if (!isset($_SESSION['email'])) {
        echo "User is not logged in!";
        exit();
    }
    $email = $_SESSION['email'];
    $_SESSION['bookproductname'] = $_POST['productName'];
    $_SESSION['bookproductPrice'] = $_POST['productPrice'];
    $_SESSION['bookproductImage'] = $_POST['productImage'];
    $_SESSION['bookduration'] = $_POST['duration'];
  
    header("location:./booknow.php");
}





?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universus Travel</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="swiper-bundle.min.css">
    <link rel="stylesheet" href="home.css">
    
</head>
<body>

<header>
        <form method="POST">
        <div class="navbar">
            <div class="nav-logo">
                <a href="home.php">
                    <img src="logo.png" alt="Logo">
                </a>
            </div>

               
    
            <div class="nav-login">
            <?php
            // Check if user is logged in
            if (!empty($_SESSION['email'])) {
                // Display user's email in the button
                echo '<button class="nav-button">' . $_SESSION['name'] . '</button>';
                // Display the submenu with My Profile and Logout options
                echo '<ul id="submenu">';
                echo '<li><a href="myProfile.php" class="submenu-button" ><i class="fa-solid fa-user"></i>My Profile</a></li>';
                echo '<li><form method="POST"><button type="submit" class="submenu-button" name="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i>Log Out</button></form></li>';
                echo '</ul>';
            } else {
                // Display the Sign In button
                echo '<button name="login-button" class="nav-button">Sign In</button>';
            }
            ?>
            </div>
            
            <div class="nav-cart">
                
                <button name="cart-button" class="nav-button">Cart</a>
            </div>
    
            
        </div>
        </form>
        <form method="POST">
        <div class="panel">
            <div class="panel-item">
                    <button name="activities-button"><i class="fa-solid fa-hat-cowboy"></i>Activities</button>
                    <button name="hotel-button"><i class="fa-solid fa-hotel"></i>Hotels</button>
                    <button name="flight-button"><i class="fa-solid fa-plane-up"></i>Flights</button>
            </div>
        </div>
        </form>
       </header>




       <!-- Single Product Details -->
<div class="small-container-product-details">
    <div class="row-product-details">
        <div class="small-container-product-details">
            <?php
            $detail = resultDetailsRequest();
            while($row = mysqli_fetch_assoc($detail)){ ?>
                <div class="row-product-details">
                    <div class="col-2-product-details">
                        <img name="productImage" src="<?php echo $row['imgsource']; ?>" width="90%" class="img-border">
                    </div>
                    <div class="col-2-product-details">
                    <form method="POST">
                    <h1 class="product-name-single"><?php echo $row['name']; ?></h1>
                    <h4 class="product-price-single">&#2547;<?php echo $row['price']; ?></h4>
                    <select name="duration" class="product-option-single">
                        <option value="" disabled>Select Duration</option>
                        <option value="1">1 Day</option>
                        <option value="3">3 Days</option>
                        <option value="5">5 Days</option>
                        <option value="7">7 Days</option>
                    </select>
                    <!-- No of People:
                    <input type="number" name="quantity" value="1" class="product-option-single"> -->
                    <!-- Hidden input fields to store session email and product details -->
                    <?php if(!empty($_SESSION['email'])){ ?>
                    <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
                    <?php } ?>
                    <input type="hidden" name="productName" value="<?php echo $row['name']; ?>">
                    <input type="hidden" name="productPrice" value="<?php echo $row['price']; ?>">
                    <input type="hidden" name="productImage" value="<?php echo $row['imgsource']; ?>">
                    <div class="button-container">
                        <!-- Book Now button -->
                        <button class="btn-product-book" name="btn-product-book">Book Now</button>
                        <!-- Add Cart button -->
                        <button type="submit" name="addtocart" class="btn-product-cart">Add Cart</button>
                    </div>
                </form>
                    </div>
                </div>
                <div class="product-details-product-details">
                    <h2><u>Service Details</u></h2>
                    <br>
                    <p align="justify"><?php echo $row['details']; ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>



<footer>

            <div class="foot-panel1" onclick="scrollToTop()">
                Back to Top
            </div>

            <script>
                function scrollToTop() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            </script>

            

            <div class="foot-panel2">

            <ul>
                    <p class="footer-font">
                        <img src="logo.png" alt="Logo" class="footer-img">
                        Universus Tourism <br>
                        <p class="footer-email footer-font">universuswebtech@gmail.com</p>
                        <p class="footer-email footer-font">+88 092024 20246</p>
                    </p>
                    
                </ul>

                <ul>
                    <p>Company</p>
                    <a href="#">About Us</a>
                    <a href="#">Destination</a>
                    <a href="#">Packages</a>
                    <a href="#">Contact Us</a>
                </ul>

                <ul>
                    <p>Help</p>
                    <a href="#">FAQ</a>
                    <a href="#">Cancel Your Order</a>
                    <a href="#">Press</a>
                </ul>

                <ul>
                    <p>More</p>
                    <a href="#">Domestic Flights</a>
                    <a href="#">Partnerships</a>
                    <a href="#">Jobs</a>
                </ul>

                <ul>
                    <p>Terms</p>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Discount Policy</a>
                    <a href="#">Accessibility</a>
                    <a href="#">Terms of Use</a>
                </ul>
            </div>

            <div class="foot-panel3">
           <p>© 2024 Universus Tourism | All rights reserved </p> 
           <p><a href="https://github.com/RogerThatTan">Made by Tanvir Hassan</a></p>
            
            </div>

            <!--Start of Tawk.to Script-->
            <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/662e59531ec1082f04e86728/1hsigprko';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
            </script>
    <!--End of Tawk.to Script-->

</footer>
</body>
</html>