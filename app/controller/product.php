<?php

include(ROOT_PATH."\app\database\dp.php");

function countTotalProducts(){
    return countValues();
}

function paginationget($startFrom,$perPage){
    $products=pagination($perPage,$startFrom);
    return $products;
}
function deleteById($id){
    if(!($id==" ")){
        delete('products',$id);
    }
    else{
        header('location:'.BASE_URL.'/index.php');
    }
}
function createNewProduct($data){
    if(!empty($data)){
        create($data);
    }
    header('location:'.BASE_URL.'/index.php');
    exit(1);
}
function productById($id){
    if($id){
      $product=  getProductById($id);
        return $product[0];
    }
    header('location:'.BASE_URL.'/index.php');
        exit(1);
    
}
function updateProduct($id,$data){
    update("products",$id,$data);
    header('location:'.BASE_URL.'/index.php');
    exit(1);
}

?>