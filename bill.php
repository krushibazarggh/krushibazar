<?php
session_start();
require_once 'config.php';
$oid=$_SESSION['oid'];
#echo $oid;
$sql="SELECT `daddress`,`dcity`,`dstate` FROM `listorder` where `orderid`='$oid'";
            $result=$conn->query($sql);
            if($result->num_rows==1)
            {
            $delivery = $result->fetch_assoc();
            }
$sql="SELECT `pid`,`qty` FROM `orderdetail` WHERE `orderid`='$oid'";
    $cartVal=$conn->query($sql);
    $cart=array();
    if($cartVal)
    {
        while($row=$cartVal->fetch_assoc())
        {
            array_push($cart,$row);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
        <h1 class="text-center">Welcome to Krushibazar</h1>
</div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="sale.php">Selling Crops</a></li>
                <li class="nav-item"><a class="nav-link" href="buying.php">Buying Products</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">logged in as:<?php echo $_SESSION['email'];?></a></li>
            </ul>
            <ul class="nav navbar-nav">
                <li class="nav-item"><a  class="nav-link" href="cart.php">My Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4 col-md-6">
    <table class="table" align=center>
        <tr>
        <th colspan=3 class="text-left">Order ID: <?php echo $oid;?><br>TO: <?php echo $_SESSION['email'];?><br>Delivery Address:<br><?php echo $delivery['daddress'];?><br><?php echo $delivery['dcity'].",".$delivery['dstate'];?></th>
        <th colspan=3 rowspan=3 class="text-right" scope="col"><?php echo date("l jS \of F Y h:i:s A");?></th>
        </tr>
        </table>
    <table class="table  table-striped" cellpadding=5px align=center>
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" scope="col">Sr. No.</th>
                            <th class="text-center" scope="col">Name</th>
                            <th class="text-center" scope="col">Category</th>
                            <th class="text-center" scope="col">Price</th>
                            <th class="text-center" scope="col">Quantity</th>
                            <th class="text-center" scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $srno=1;
                        $cart_total=0;
                        $cart_qty=0;
                        $sql="SELECT `pid`,`pname`,`category`,`price` FROM `product` WHERE `pid`=?";
                        $stmt=$conn->prepare($sql);
                        $stmt->bind_param('s',$param_pid);
                        foreach($cart as $key=>$value)
                        {
                            $param_pid=$value['pid'];
                            $stmt->execute();
                            $result=$stmt->get_result();
                            $item=$result->fetch_array(MYSQLI_ASSOC);
                            $cart_total+=($item['price']*$value['qty']);
                            $cart_qty+=$value['qty'];
                            ?>
                            <tr>
                            <th class="text-center"><?php echo $srno ?></th>
                            <?php $srno++?>
                                <th class="text-center"><?php echo $item['pname']?></th>
                                <th class="text-center"><?php echo $item['category']?></th>
                                <th class="text-center"><?php echo $item['price']?></th>
                                <th class="text-center"><?php echo $value['qty']?></th>                        
                                <th class="text-center"><?php echo $item['price']*$value['qty']; ?></th>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th colspan=4></th>
                            <th class="text-center">Total<br>Quantity: <?php echo $cart_qty; ?></th>
                            <th class="text-center">Cart Total :<br><?php echo $cart_total; ?></th>
                                                    </tr>
                        </tbody>
                </table>
                <div class="d-flex flex-row-reverse bd-highlight my-4">
                    <!-- Button trigger modal -->
                    <button type="submit" class="btn btn-primary">
                    Save
                    </button>&nbsp;&nbsp;&nbsp;
                    <a href="home.php"><button type="button" class="btn btn-primary" >
                    Close
                    </button>
                    </a>
                </div>
                </div>
                </body>
</html>