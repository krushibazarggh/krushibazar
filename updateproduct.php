<?php
$err="<br>";
$success=false;
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
if(isset($_POST['submit']))
{
    if(empty(trim($_POST['addqty'])) || trim($_POST['addqty'])<1)
    {
        $err.="Enter valid Quantity<br>";
        $success=false;
    }
    if(empty(trim($_POST['cinfo'])))
    {
        $err.="Enter valid information<br>";
        $success=false;
    }
    if($err=="<br>")
    {
        #echo $_POST['oqty']." ".$_POST['addqty']." ".$_POST['cinfo']." ".$_POST['pid'];
        $newqty=$_POST['oqty']+$_POST['addqty'];
        #echo $newqty;
        $cinfo=$_POST['cinfo'];
        $prid=$_POST['pid'];
        #echo $prid;
        $sql="UPDATE `product` SET `qty`=$newqty,`pinfo`='$cinfo' WHERE `pid`=$prid";
        #echo $sql;
        $result=$conn->query($sql);
        if($result)
            $success=true;
    }
}
$sql="SELECT * FROM `product` WHERE `userid`='$userid'";
$uproduct=$conn->query($sql);
$products=array();
if($uproduct)
{
    while($row=$uproduct->fetch_assoc())
    {
        array_push($products,$row);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/4.8.0/full/ckeditor.js"></script>
    <style>
    .btn-light{
        background-color:white;
        outline:white;
        text:black;
        border-radius:0px !important;
        border:0;
    }
    .cont{
        height:100vh;
    }
    </style>
<title>Update Products</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Welcome to Krushibazar</h1>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
            <strong>Success</strong> Product Addedd Successfully.<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'  >&times</span>
            </button>  
            </div>";
        }
        elseif($err!="<br>")
        {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Failed to Add the Product</strong>";
            echo $err;
            echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'  >&times;</span>
            </button> 
            </div>";
        }
    ?>
    <div class="container-expand my-0">
        <div class="row">
            <div class="col-md-2">
                <div class="container light shadow cont">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <?php
                        if($uproduct->num_rows==0)
                        {
                            echo "<h4 class='text-center'>You haven't added any products</h4>";
                        }
                        else
                        { ?>
                            <h4 class="text-center mt-4">Your Products</h4>
                            <?php 
                                $srno=1;
                                foreach($products as $key=>$value)
                                {?>
                                    <a class="nav-link <?php if(isset($_POST['submit']) && $_POST['pid']==$value['pid']) echo 'active'; ?>" id="v-pills-<?php echo $value['pname']; ?>-tab" data-toggle="pill" href="#v-pills-<?php echo $value['pname']; ?>" role="tab" aria-controls="v-pills-<?php echo $value['pname']; ?>" aria-selected="true"><?php echo $value['pname']; ?></a>
                            <?php }
<<<<<<< HEAD
                        } ?>
=======
                            } ?>
                        </ul>
                   
                </div>
            </div>
            
                <?php
                    if(isset($_POST['editProduct']))
                    { 
                ?>
                <div class="container shadow-sm col-md-7 h-100">
                <br>
                <h4>Edit Product</h4>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="pid" value=<?php echo $productDetail['pid']; ?>>
                    <input type="hidden" name="oqty" value=<?php echo $productDetail['qty']; ?>>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="cname">Crop name</label>
                            <input class="form-control" type="text" disabled value='<?php echo $productDetail['pname']; ?>' name="cname" id="cname" placeholder="Enter cname">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cname">Category</label>
                            <input class="form-control" type="text" disabled value='<?php echo $productDetail['category']; ?>' name="ccategory" id="cname" placeholder="Enter cname">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="price">Price(₹)</label>
                            <input class="form-control" type="number" disabled value=<?php echo $productDetail['price']; ?> name="price" id="price" placeholder="Enter Price of 500 grams">
                        </div>
                        <div class="form-group col-md-4"> 
                            <label for="qty">Quantity Available</label>
                            <input class="form-control" type="number" disabled value='<?php echo $productDetail['qty']; ?>' name="qty" id="qty" placeholder="Enter Quantity(no of packets 500 grams)">
                        </div>
                        <div class="form-group col-md-4"> 
                            <label for="qty">New Quantity</label>
                            <input class="form-control" type="number" name="addqty" id="qty" placeholder="Enter Quantity(no of packets 500 grams)">
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-12"> 
                            <label for="cinfo">Enter Information</label>
                            <textarea  name="cinfo" id="cinfo" rows="12"><?php echo $productDetail['pinfo']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-3"> 
                            <button type="submit" name="submit" class="btn btn-primary">Update Product</button>
                        </div>
>>>>>>> 6361fa4b77c806682b29473f6e05a6867f7b61cb
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade my-4 <?php if(!isset($_POST['submit'])) echo "active show"; ?>" id="v-pills" role="tabpanel" aria-labelledby="v-pills-1-tab">
                    <h4 class="text-center">Please Select a Product to Edit</h4>
                </div>
                    <?php
                        if($uproduct->num_rows!=0)
                        {
                            foreach($products as $key=>$value)
                            {?>
                                <div class="tab-pane fade my-4 <?php if(isset($_POST['submit']) && $_POST['pid']==$value['pid']) echo 'active show'; ?>" id="v-pills-<?php echo $value['pname']; ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $value['pname']; ?>-tab">
                                <div class="row">
                                    <div class="container shadow-sm col-md-9 h-100">
                                        <h4>Edit Product</h4>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="pid" value=<?php echo $value['pid']; ?>>
                                            <input type="hidden" name="oqty" value=<?php echo $value['qty']; ?>>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="cname">Crop name</label>
                                                    <input class="form-control" type="text" disabled value='<?php echo $value['pname']; ?>' name="cname" id="cname" placeholder="Enter cname">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="cname">Category</label>
                                                    <input class="form-control" type="text" disabled value='<?php echo $value['category']; ?>' name="ccategory" id="cname" placeholder="Enter cname">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="price">Price(₹)</label>
                                                    <input class="form-control" type="number" disabled value=<?php echo $value['price']; ?> name="price" id="price" placeholder="Enter Price of 500 grams">
                                                </div>
                                                <div class="form-group col-md-4"> 
                                                    <label for="qty">Quantity Available</label>
                                                    <input class="form-control" type="number" disabled value='<?php echo $value['qty']; ?>' name="qty" id="qty" placeholder="Enter Quantity(no of packets 500 grams)">
                                                </div>
                                                <div class="form-group col-md-4"> 
                                                    <label for="qty">New Quantity</label>
                                                    <input class="form-control" type="number" name="addqty" id="qty" placeholder="Enter Quantity(no of packets 500 grams)">
                                                </div>
                                            </div>
                                            <div class="form-row"> 
                                                <div class="form-group col-md-12"> 
                                                    <label for="cinfo">Enter Information</label>
                                                    <textarea  name="cinfo" id="cinfo-<?php echo $value['pname']; ?>" rows="12"><?php echo $value['pinfo']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-row"> 
                                                <div class="form-group col-md-3"> 
                                                    <button type="submit" name="submit" class="btn btn-primary">Add Product</button>
                                                </div>
                                            </div>
                                        </from>
                                        <script>
                                            CKEDITOR.replace( 'cinfo-<?php echo $value['pname']; ?>' );
                                        </script>
                                    </div>
                                    <div class="col-md-3">
                                        <div class='card shadow-sm'>
                                            <img class='card-img-top' src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($value['image']); ?>" alt='Card image cap'>
                                            <div class='card-body'>
                                                <h4 class='card-title text-center'><?php echo $value['pname'];?></h4>                    
                                                <form action="" method="post">
                                                    <input type="hidden" name="pid" value=<?php echo $value['pid']; ?>>
                                                </form>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <?php }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>