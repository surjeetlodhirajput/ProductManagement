<?php
require('conncetion.php');

function countValues($table="products")
{
    global $conn;
    $sql="SELECT COUNT(*) FROM $table";
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    $products=$stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
    return $products["COUNT(*)"];
    
}
function executeQuery($sql,$data)
{   
    global $conn;
    $stmt=$conn->prepare($sql);
        $values=array_values($data);
        $types= str_repeat('s',count($values));
        $stmt->bind_param($types,...$values);
        $stmt->execute();
        return $stmt;
}

function create($data,$table="products")
{
    global $conn;
    $sql="INSERT INTO $table SET ";
    $i=0;
    foreach($data as $key=>$value)
    {
        if($i===0)
        {
            $sql=$sql." $key=? ";
        }
        else 
        {
            $sql=$sql.", $key=?";
        }
        $i++;
    }

    $stmt=executeQuery($sql,$data);
    $id=$stmt->insert_id;
    return $id;
}

function update($table="products",$id,$data)
{
    global $conn;
    $sql="UPDATE $table SET ";
    $i=0;
    foreach($data as $key=>$value)
    {
        if($i===0)
        {
            $sql=$sql." $key=? ";
        }
        else 
        {
            $sql=$sql.", $key=?";
        }
        $i++;
        }
        $sql=$sql." WHERE id=?";
        $data['id']=$id;
        $stmt=executeQuery($sql,$data);
        return $stmt->affected_rows;
}

function delete($table,$id)
{
    global $conn;
    $sql="DELETE FROM $table WHERE ";
    
        $sql=$sql." id=?";
  
        $stmt=executeQuery($sql,['id'=>$id]);
        return $stmt->affected_rows;
}
function getProductById($id)
{
    global $conn;
    //SELECT * FROM posts where pulished=1
    $sql="SELECT * FROM products WHERE id=?";
  $stmt=executeQuery($sql,['id'=>$id]);
  $records=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  return $records;  
}
function pagination($RowPerPage,$page_result){
global $conn;
$sql="SELECT * FROM products LIMIT " . $page_result . ',' . $RowPerPage;
$stmt=$conn->prepare($sql);
$stmt->execute();
$products=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
return $products;
}

?>