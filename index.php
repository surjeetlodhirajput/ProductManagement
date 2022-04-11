<?php include('./path.php'); 
include(ROOT_PATH.'/app/controller/product.php');
$page=0;
$postPerPage=4;

$data=array();
if(isset($_REQUEST['btn-create'])){
    $data['name']=$_POST['name'];
    $data['status']=$_POST['status'];
    $data['price']=$_POST['price'];
    $data['company']=$_POST['company'];
    $data['image']=$_FILES['image']['name'];
    $target_file=ROOT_PATH."/assest/images/".$data['image'];
    $uploaded= move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    if ($uploaded) {
      createNewProduct($data);
    } else if(!$uploaded) {
echo      '<script>alert("Sorry! There was some error while uploading your image")</script>';
//header('location:'.BASE_URL.'/index.php');
    }
}

$productOne="";
if(isset($_REQUEST['u_id'])){
$productOne=productById($_REQUEST['u_id']);
//print_r($productOne);
}
if(isset($_REQUEST['d_id'])){
  deleteById($_REQUEST['d_id']);
}
if(isset($_REQUEST['BTN-UPDATE'])){
  $data['name']=$_POST['name'];
  $data['price']=$_POST['price'];
  $data['status']=$_POST['status'];
    $data['company']=$_POST['company'];
    $data['image']=!empty($_FILES['image']['name'])?$_FILES['image']['name']:productById($_POST['id'])['image'];
    if (!empty($_FILES['image']['name'])) {
      $target_file=ROOT_PATH."/assest/images/".$data['image'];
      $uploaded= move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);  
      updateProduct($_POST['id'],$data);
    } else {
      updateProduct($_POST['id'],$data);
//header('location:'.BASE_URL.'/index.php');
    }

}
if(isset($_GET["page"])){//to check when click on the button
$page=$_GET['page'];
}
else{
  $page=1;
}
$startFromPage=($page-1)*$postPerPage;
$products=paginationget($startFromPage,$postPerPage);
$productsCount=countTotalProducts();
$productsCount=ceil($productsCount/$postPerPage);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management WebApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="icon" type="image/png" href="./delivery-box.png">
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine:bold,bolditalic|Inconsolata:italic|Droid+Sans|Cantarell:italic">
    <style>
*{
 font-family: Inconsolata;
}
        .card{
            width:300px;
            margin-left:20px;
        }
        body{
            background:#4d4d4d;
        }
        input[type="text"],input[type="number"]{
            margin-top:3px;
            width:50%;
             border:1px solid black;
 
  
        }input[type="file"]{
            margin-top:3px;
            border:1px solid black;
            color:white;
        }

select{
 
  border:1px solid black !important;

}
        button{
            margin-top:5px;
            width:50%;
        }
        button:hover{
          border:1px solid white !important;
        }
        .container{
            padding:0;
            margin:0;
            align-content:center;
        }

        .form-container{
        
         width:100vw;

position:relative;
height:auto;

        }
        .col:hover{
          margin-left:-5px;
        }

        form{
            margin-top:4px;
            box-sizing:border-box;
            width:auto;
            margin-left:30vw;
        }
        .data-container{
            width:100vw;
            display:flex;
            height:10%;
            padding-left:50px;
            padding-top:10px

        }
        .pagination{
            margin-left:70px;
            margin-top:2px;
        }
@media (max-width:900px){
.card-deck{

display:block !important;
margin-left:20%;
}
.card-body{
  height:100px !important;
}
.card{
  margin-top:20px;
}
.pagination{
  margin-left:35%;
}
}
 
    </style>
</head>
<body>
<div class="container web-container">
 <div class="form-container container-fluid">
   <?php if($productOne==""): ?>
 <form method="post" action=<?php echo BASE_URL.'/index.php'; ?> enctype="multipart/form-data">
 <div class="row">
  <div class="col">
    <input type="text" class="form-control" placeholder="Product Name" aria-label="First name" name="name" required>
  </div>
</div>
<div class="row">
  <div class="col">
    <input type="number" class="form-control" placeholder="price" aria-label="First name" name="price" required>
  </div>
</div>
<div class="row">
  <div class="col">
    <input type="text" class="form-control" placeholder="company name" aria-label="First name" name="company" required>
  </div>
</div>
<div class="row">
  <div class="col">
  <select class="form-select" aria-label="status" name="status" style="width:50%;margin-top:3px;";>
  <option value="SOLD">SOLD</option>
  <option value="UNSOLD" selected>UNSOLD</option>
</select>
  </div>
</div>

<div class="row">
<div class="col">
<input type="file" class="form-control w-50"  name="image" required>
</div>
</div>
<button type="submit" class="btn btn-primary" name="btn-create">Create</button>
</form>
<?php else: ?>
  <!--for updated feilf-->
  <form method="post" action=<?php echo BASE_URL.'/index.php'; ?> enctype="multipart/form-data">
 <div class="row">
 <input type="hidden" class="form-control" value="<?php echo $productOne['id']; ?>" placeholder="Product Name" aria-label="First name" name="id" required>
  <div class="col">
    <input type="text" class="form-control" value="<?php echo $productOne['name']; ?>" placeholder="Product Name" aria-label="First name" name="name" required>
  </div>
</div>
<div class="row">
  <div class="col">
    <input type="number" class="form-control" value="<?php echo $productOne['price']; ?>" placeholder="price" aria-label="First name" name="price" required>
  </div>
</div>
<div class="row">
  <div class="col">
    <input type="text" class="form-control" placeholder="company name" value="<?php echo $productOne['company']; ?>" aria-label="First name" name="company" required>
  </div>
</div>
<div class="row">
  <div class="col">
  <select selected="<?php echo $productOne['status']; ?>" class="form-select" aria-label="status" name="status" style="width:50%;margin-top:3px;" >
  <option value="SOLD">SOLD</option>
  <option value="UNSOLD" selected>UNSOLD</option>
</select>
  </div>
</div>

<div class="row">
<div class="col">
<input type="file" class="form-control w-50"  name="image"  >
</div>
</div>
<button type="submit" class="btn btn-primary" name="BTN-UPDATE">Create</button>
</form>
<?php endif; ?>
 </div>
 <!--tart of the data conainer part-->
 <div  class="data-container container-fluid " style="block-size: fit-content">
 <div class="card-deck d-flex flex-row" >

 
   <?php foreach($products as $key=>$value): ?>
  <div class="card ">
    <img src="<?php echo BASE_URL."/assest/images/".$value['image']; ?>" class="card-img-top h-50" style="height:fit-content;block-size: fit-content;" alt="poduct-image"/>
    <div class="card-body" style="height:10px;padding-bottom:0;min-height:10px;padding:3px">
      <h5 class="card-title  text-center">Product: <?php echo $value['name']."  (".$value['status'].")"; ?></h5>
      <p class="card-text  text-center">Price: <?php echo $value['price']."(Rs.)"; ?></p>
      <p class="card-text  text-center">Company: <?php echo $value['company']; ?></p>
    </div>
    <div class="card-footer btn-group " >
    <a class="btn btn-success"  href="<?php echo BASE_URL.'/index.php?u_id='.$value['id']; ?>" name="button-update">Update</a>
    <a class="btn btn-danger" style="margin-left:2px;" href="<?php echo BASE_URL.'/index.php?d_id='.$value['id']; ?>" name="button-delete" >Delete</a>
    </div>
  </div>
  <?php endforeach ?>


</div>
 </div>
 <!--start of pagination -->
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <?php if($page>1): ?>
      <li class="page-item">
      <a class="page-link" href="<?php echo "index.php?page=".$page-1; ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
      <?php endif ?>

<?php
for($i=$page;$i<$page+$postPerPage&&$i<=$productsCount;$i+=1):
?>
    <li class="page-item"><a class="page-link" href="<?php echo "index.php?page=".$i; ?>"><?php echo $i ?></a></li>
    <!--li class="page-item"><a class="page-link" href="index.php?page=1">2</a></li>
    <li class="page-item"><a class="page-link" href="index.php?page=1">3</a></li-->
    <?php  endfor; ?>
  <?php if($page<$productsCount):?>
    <li class="page-item">
      <a class="page-link" href="<?php echo "index.php?page=".$page+1; ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  <?php endif ?>
  </ul>
</nav>
<!--end of pagination -->
 <!--Ending of the container-->
</div>
</body>
</html>