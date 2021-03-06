<?php
  $err1="<br>";
  $success=false;
  $err="<br>";
  session_start();
  require_once('./classes/user.php');
  if(isset($_SESSION['user']))
  {
    $user=unserialize($_SESSION['user']);
    if($user->category!='user')
      header('location:logout.php');
  }
  else header('location:login.php');

  require_once 'config.php';
  $userid=$user->userid;
  $email=$user->email;
  $firstname=$user->fname;
  $lastname=$user->lname;
  $address=$user->address;
  $state=$user->state;
  $city=$user->city;
  $phonenumber=$user->phno;
  $gender=$user->gender;
  $dob=$user->dob;

  #Address Info Validation
  if(isset($_POST["submit"]))
  {
    if(empty(trim($_POST['address']))|| empty(trim($_POST['city'])) || empty(trim($_POST['state'])))
    {
      $err.="Enter details for address<br>";
      $success=false;
    }
    elseif(empty(trim($_POST['cardname']))|| empty(trim($_POST['cardno'])) || empty(trim($_POST['date'])) || empty(trim($_POST['cvv'])) )
    {
      $err.="Enter all details<br>";
      $success=false;
    }
    elseif(strlen((string)trim($_POST['cardno']))!=16)
    {
      $err.="Enter valid Card Number<br>";
      $success=false;
    }
    elseif((strtotime($_POST['date']))<strtotime(date("F Y")))
    {
      $err.="vaild date";
      $success=false;
    }
    else
    {
      $dadd=$_POST["address"];
      $dcity=$_POST["city"];
      $dstate=$_POST["state"];
      $cardno=$_POST["cardno"];
      #Add the info to listorder Table
      $sql="INSERT INTO `listorder` (`daddress`,`dcity`,`dstate`,`cardno`,`userid`,`odate`) VALUES ('$dadd','$dcity','$dstate','$cardno','$userid',CURRENT_TIMESTAMP)";
      $insert = $conn->query($sql);
      $oid = $conn->insert_id; #Get the last added OrderID
      if($insert)
      {    
        #Select the product in cart
        $sql="SELECT `productid`,`qty` FROM `cart` WHERE `userid`='$userid'";
        $cartVal=$conn->query($sql);
        $cart=array();
        if($cartVal)
        {
          while($row=$cartVal->fetch_assoc())
          {
            array_push($cart,$row);
          }
        }  
        foreach($cart as $key=>$value)
        {
          $pid=$value['productid'];
          $qty=$value['qty'];   
          #Insert each product selected from cart to orderdetails table corresponding to the newly added orderID                        
          $sql="INSERT INTO `orderdetail` (`pid`,`qty`,`orderid`) VALUES ('$pid','$qty','$oid')";
          $insub = $conn->query($sql);
          $sql="SELECT `qty` from `product` where `pid`='$pid'";
          $select=$conn->query($sql);
          $product=$select->fetch_assoc();
          $pQty=$product['qty'];
          $pQty-=$qty;
          $sql="UPDATE `product` SET `qty`='$pQty' WHERE `pid`='$pid'";
          $update=$conn->query($sql);
        }
        #Delete the Product from the cart
        $dsql="DELETE FROM `cart` WHERE `userid`='$userid'";
        $dcart=$conn->query($dsql);
        $success=true;
        header("location:listorders.php");
      }
      else
      {
        $success=false;
        $err.="Failed to Upload the Details<br>";
      }
              
    }
  }
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Payment</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
<img src="https://cdn.discordapp.com/attachments/809280919991091212/824313211875622963/1d4f1ba8-89b8-476e-9de4-e15e896c81c9.png" width="50" alt="">
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
    <?php 
    if($success)
    {
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Success</strong>Payment successfully done.<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'  >&times</span>
      </button>  
      </div>";
    }
    elseif($err!="<br>")
    {
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Failed to Process Your Payment</strong>";
      echo $err;
      echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'  >&times;</span>
      </button> 
      </div>";
    }
    ?>
<form action="" method="post">
<div class="container col-md-5 mt-10">
          <div class="form-row">
              <div class="form-group col-md-12">
                  <label for="address">Address</label>
                  <input class="form-control py-5" type="textarea" name="address" id="address" value=<?php echo $address;?> placeholder="Enter your Address">
              </div>
          </div >
          <div class="form-row">
                <div class="form-group col-md-6">
                        <label for="city">City</label>
                        <input class="form-control" type="text" name="city" id="city" value=<?php echo $city;?> placeholder="Enter City">
                </div>
                <div class="form-group col-md-6">
                        <label for="state">State</label>
                        <input class="form-control" type="text" name="state" id="state" value=<?php echo $state;?> placeholder="Enter State">
                </div>            
          </div>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#payment">
            Pay Through Card
          </button>

        <!-- Modal -->
          <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Enter card Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                        <div class="form-row">
                        <div class="form-group col-md-12">
                        <label for="cardname">Name on Card</label>
                                  <input class="form-control" type="text" name="cardname" id="cardname" placeholder="Enter Name on card">
                              </div>
                              </div>
                              <div class="form-row">
                        <div class="form-group col-md-12">
                        <label for="cardno">Card Number</label>
                                  <input class="form-control" type="number" name="cardno" id="cardno" placeholder="Enter Card Number">
                              </div>
                              </div>
                              <div class="form-row">
                              <div class="form-group col-md-6">
                              <label for="date">Expiration</label>
                                  <input class="form-control" type="month" name="date" id="date" placeholder="Valid Date">
                              </div>
                              <div class="form-group col-md-6">
                              <label for="cvv">Security Code</label>
                                  <input class="form-control" type="password" name="cvv" id="cvv" placeholder="CVV">
                              </div>                    
                              </div>
                        </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" name="submit" class="btn btn-primary">Proceed</button>
                </div>
              </div>
            </div>
          </div> 
</div>
</form>
</body>
</html>
