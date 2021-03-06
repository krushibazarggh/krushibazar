<?php
    session_start();
    require_once('./classes/user.php');
    if(isset($_SESSION['user']))
    {
        $user=unserialize($_SESSION['user']);
        if($user->category!='user')
            header('location:logout.php');
    }
    else header('location:login.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Home</title>
</head>
<style>
body {
  background-image:linear-gradient(rgba(0,0,0,0.1),rgba(0,0,0,0.7)),url('./images/bg.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}
</style>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <a href="home.php" title="Home">
    <img src="https://cdn.discordapp.com/attachments/809280919991091212/824313211875622963/1d4f1ba8-89b8-476e-9de4-e15e896c81c9.png" width="50" alt="">
        </a>
        <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="sale.php">Selling Crops</a></li>
                <li class="nav-item"><a class="nav-link" href="buying.php">Buying Products</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">logged in as:<?php echo $user->email;?></a></li>
            </ul>
            <ul class="nav navbar-nav">
            <li class="nav-item"><a  class="nav-link" href="cart.php">My Cart</a></li>
            <li class="nav-item"><a  class="nav-link" href="listorders.php">Your Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1 class="text-center text">Welcome to Krushibazar</h1>
    </div>
    <div class="container text-light">
        <p class="text-light">Agriculture, with its allied sectors, is unquestionably the largest livelihood provider in India, more so in the vast rural areas. It also contributes a significant figure to the Gross Domestic Product (GDP). Sustainable agriculture, in terms of food security, rural employment, and environmentally sustainable technologies such as soil conservation, sustainable natural resource management and biodiversity protection, are essential for holistic rural development. Indian agriculture and allied activities have witnessed a green revolution, a white revolution, a yellow revolution and a blue revolution.
        This section provides the information on agriculture produces; machineries, research etc. Detailed information on the government policies, schemes, agriculture loans, market prices, animal husbandry, fisheries, horticulture, loans & credit, sericulture etc. is also available.
        </p>
        <h4>Important links</h4> 	  
        <ul >
            <li><a class="text-warning" href="/website-ministry-agriculture-farmers-welfare">Website of Ministry of Agriculture &amp; Farmers Welfare</a></li>
            <li><a class="text-warning" href="/departments-agriculture-states-and-union-territories">Departments of Agriculture of states and Union Territories</a></li>
            <li><a class="text-warning" href="/website-department-animal-husbandry-dairying-and-fisheries-0">Website of Department of Animal Husbandry Dairying and Fisheries</a></li>
            <li><a class="text-warning" href="/website-directorate-cashewnut-cocoa-development">Website of Directorate of Cashewnut &amp; Cocoa Development</a></li>
            <li><a class="text-warning" href="/farmers-portal-india-department-agriculture-and-cooperation">Farmers&#039; Portal of India by Department of Agriculture and Cooperation</a></li>	  
        </ul> 
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
