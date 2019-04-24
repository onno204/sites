<?php 
    require "../config.php";
    if(isUserLoggedIn() == false){
        die("<h1>Je moet ingelogged zijn voor deze actie!</h1><a href=\"login\">Login</a>");
    }
    
    if(doesUserHavePermission("manageproducts") == false){
        die("<h1>You don't have permission to view this page</h1>");
    }
?>
<h1>manage products</h1>
<?php include "../nav.php"; ?>

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>


<h1>Add Categorie</h1>
<form method="POST">
<?php
$catenteredAll = true;
$cattitle = "";
$catdiscription = "";
if(isset($_POST['cattitle']) && strlen($_POST['cattitle']) >=1 ){
    $cattitle = $_POST['cattitle'];
}else{ $catenteredAll = false; }
?>titel: <input type="text" name="cattitle" value="<?php echo $cattitle;?>"> <br><?php

if(isset($_POST['catdescription']) && strlen($_POST['catdescription']) >=1 ){
    $catdiscription = $_POST['catdescription'];
}else{ $catenteredAll = false; }
?>omschrijving: <input type="text" name="catdescription" value="<?php echo $catdiscription;?>"> <br>
<input type="submit" name="catsubmitbutton" value="Submit">
    <?php 
        if(isset($_POST['catsubmitbutton']) && ($catenteredAll !== true)){
            echo "<h1>gelieven overal iets in te vullen</h1>";
        } 
        if(isset($_POST['catsubmitbutton']) && ($catenteredAll === true)){
            $stmt = $conn->prepare("INSERT INTO category (title, description) VALUES (?,?)");
            $stmt->bind_param("ss", $cattitle, $catdiscription);
            $stmt->execute();
            ?><h1>Categorie aangemaakt</h1><?php
        }
    ?>
</form> 
<table id="categorien">
    <tr>
        <th>id</th>
        <th>title</th>
        <th>description</th>
        <th>disabled</th>
    </tr>
    <?php
        $stmt = $conn->prepare("SELECT * FROM category WHERE disabled != 1");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($data = $result->fetch_assoc()){
            ?>
            <tr>
                <th><?php echo $data['id']; ?></th>
                <th><?php echo $data['title']; ?></th>
                <th><?php echo $data['description']; ?></th>
                <th><?php echo $data['disabled']; ?></th>
            </tr>
            <?php
        }
    ?>
</table>

<br><br><br>
<h1>Add product</h1>
<form method="POST">
<?php
$prodenteredAll = true;
$prodtitle = "";
$proddiscription = "";
$prodprice = 0;
$prodcategory = 0;
if(isset($_POST['prodtitle']) && strlen($_POST['prodtitle']) >=1 ){
    $prodtitle = $_POST['prodtitle'];
}else{ $prodenteredAll = false; }
?>titel: <input type="text" name="prodtitle" value="<?php echo $prodtitle;?>"> <br><?php

if(isset($_POST['proddiscription']) && strlen($_POST['proddiscription']) >=1 ){
    $proddiscription = $_POST['proddiscription'];
}else{ $prodenteredAll = false; }
?>omschrijving: <input type="text" name="proddiscription" value="<?php echo $proddiscription;?>"> <br><?php

if(isset($_POST['prodprice']) && strlen($_POST['prodprice']) >=1 ){
    $prodprice = floatval($_POST['prodprice']);
}else{ $prodenteredAll = false; }
?>prijs: <input type="number" name="prodprice" step="0.01" value="<?php echo $prodprice;?>"> <br><?php

if(isset($_POST['prodcategory']) && strlen($_POST['prodcategory']) >=1 ){
    $prodcategory = intval($_POST['prodcategory']);
}else{ $prodenteredAll = false; }
?>categorieID: <input type="number" name="prodcategory" value="<?php echo $prodcategory;?>"> <br>

<input type="submit" name="prodsubmitbutton" value="Submit">
    <?php 
        if(isset($_POST['prodsubmitbutton']) && ($prodenteredAll !== true)){
            echo "<h1>gelieven overal iets in te vullen</h1>";
        } 
        if(isset($_POST['prodsubmitbutton']) && ($prodenteredAll === true)){
            $stmt = $conn->prepare("INSERT INTO products (title, description, price, categoryid) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $prodtitle, $proddiscription, $prodprice, $prodcategory);
            $stmt->execute();
            ?><h1>product aangemaakt</h1><?php
        }
    ?>
</form>
<table id="producten">
    <tr>
        <th>id</th>
        <th>title</th>
        <th>description</th>
        <th>price</th>
        <th>categoryid</th>
        <th>disabled</th>
    </tr>
    <?php
        $stmt = $conn->prepare("SELECT * FROM products WHERE disabled != 1");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($data = $result->fetch_assoc()){
            ?>
            <tr>
                <th><?php echo $data['id']; ?></th>
                <th><?php echo $data['title']; ?></th>
                <th><?php echo $data['description']; ?></th>
                <th><?php echo $data['price']; ?></th>
                <th><?php echo $data['categoryid']; ?></th>
                <th><?php echo $data['disabled']; ?></th>
            </tr>
            <?php
        }
    ?>
</table>


