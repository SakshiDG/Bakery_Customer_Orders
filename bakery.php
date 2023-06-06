<!DOCTYPE html>
<html>
<head>
<h1>Welcome to the Bakery Database!!</h1>
</head>
<style>
body {
padding: 70px 0;
/* 
  border: 3px solid green;
 */
  text-align: center;
  }
.center {
  margin-left: auto;
  margin-right: auto;
}
ol {
  margin-left: 43%;
  text-align: left;
  list-style-position: inside;
}
table, tr, th, td{
border: 2px solid;
border-collapse: collapse;
}
th, td{
padding:5px;
}
</style>
<body style="background-image: url('https://static.vecteezy.com/system/resources/previews/001/428/611/non_2x/rustic-bread-and-bakery-banner-vector.jpg');">
<form name="form" action="" method="get">
  <label for="cid">Enter your Customer Id to see all your orders</label>
  <br><input type="text" id="cid" name="cid">
 <input type="submit" value="Submit" name = "submit">
</form>


<?php
$db_host = '127.0.0.1';
$db_user = 'root';
$db_password = 'root';
$db_db = 'PDS';
$db_port = 8889;

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_db, $db_port);

if ($mysqli->connect_error)
{
    echo 'Errno: ' . $mysqli->connect_errno;
    echo '<br>';
    echo 'Error: ' . $mysqli->connect_error;
    exit();
}
if (isset($_GET['ingredient_details']))
{
    $cakeid = $_GET['ingredient_details'];
    $query = "Select iname, qty from contain join ingredient on contain.ingredid = ingredient.ingredid where contain.cakeid = $cakeid;";
    $ingred_details = $mysqli->query($query);
    if ($ingred_details->num_rows > 0)
    {
        echo "<br>" . "Cake Ingredients and their Quantity" . "<br><br>";
        echo "<table border='1'; class = 'center'>
  <tr>
  <th>Ingredient Name</th>
  <th>Quantity</th>
  </tr>";

        while ($row = $ingred_details->fetch_assoc())
        {
            echo "<tr>";
            echo "<td>" . $row['iname'] . "</td>";
            echo "<td>" . $row['qty'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
}
if (array_key_exists('submit', $_GET))
{
    $cid = $_GET['cid'];
    $sql = "SELECT custid, orders.cakeid, cakename, ordertime, pickuptime, pricepaid 
 from Orders join Cake on orders.cakeid = cake.cakeid where orders.custid = $cid order by ordertime desc;";
    $result = $mysqli->query($sql);
    
    if ($result->num_rows > 0)
    {
    echo " <br><br> All your past orders - <br><br>";
        echo "<table border='1'; class = 'center'>
  <tr>
  <th>Customer Id</th>
  <th>Cake Id</th>
  <th>Cake Name</th>
  <th>Order Time</th>
  <th>Pickup Time</th>
  <th>Price Paid</th>
  </tr>";

        while ($row = $result->fetch_assoc())
        {
            $cakeid = $row['cakeid'];
            echo "<tr>";
            echo "<td>" . $row['custid'] . "</td>";
            echo "<td>" . $row['cakeid'] . "</td>";
            echo "<td><a href = '/bakery.php?ingredient_details=$cakeid'>" . $row['cakename'] . "</a></td>";
            echo "<td>" . $row['ordertime'] . "</td>";
            echo "<td>" . $row['pickuptime'] . "</td>";
            echo "<td>" . $row['pricepaid'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    else
    {
        echo "<h2> No Orders placed by Customer</h2>";
    }

    $mysqli->close();
}
?>

</body>
</html>