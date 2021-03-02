<?php
ob_start();
include("./inc/loginheader.php");
include("../config/conn.php");
include("./inc/SimpleXLSX.php");
if(isset($_POST["submit"]))
{
    $username=$_POST["username"];
    $password=$_POST["password"];
    $type1=$_POST["type1"];
    $type=$_POST["type"];
    if($username == "" || $password=="")
    {
        echo "<h1> all fields are required</h1>";
    }
    else
    {
        $query=$connection->prepare("INSERT INTO students(username,userpassword,department,usertype) VALUES(?,?,?,?)");
        $query->bind_param("ssss",$username,$password,$type1,$type);
        $query->execute();
        header ("location:addusers.php");
    }
    echo "<h1> user added successfully</h1>";
}
//add data from excel file using SimpleXLSX.php from github https://github.com/shuchkin/simplexlsx 
if(isset($_FILES["excel"]["name"]))
{
    $xlsx = SimpleXLSX::parse($_FILES["excel"]["tmp_name"]);
	$query1=$connection->prepare("INSERT INTO students(username,userpassword,department,usertype) VALUES(?,?,?,?)");
    $query1->bind_param("ssss",$username,$password,$type1,$type);
    foreach($xlsx->rows() as $fields)
    {
        $username= $fields[0];
        $password=$fields[1];
        $type1=$fields[2];
        $type=$fields[3];
        $query1->execute();
        header ("location:addusers.php");
    }
   
         
}
?>
<section class="maincontent">
<h1> this is add users page</h1>
<section class="addform">
    <form method="post" action="" >
        <label for="username">User name:</label>
        <input type="text" name="username" id="username" placeholder="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="password" required><br>
        <label >Choose a department:</label>
        <select id="type1" name="type1">
                <option value="Power">Power</option>
                <option value="Electronic">Electronic</option>
                <option value="Communication">Communication</option>
                <option value="Computer">Computer</option>
                <option value="Civil">Civil</option>
                <option value="Mechanic">Mechanic</option>
                <option value="Chemical">Chemical</option>
                <option value="matrial">matrial</option>
                <option value="Architecture">Architecture</option>
                <option value="Roads">Roads</option>
            </select>
            
        <label for="type">Type</label>
            <select id="type" name="type">
                <option value="PhD">PhD</option>
                <option value="MSc">MSc</option>
                <option value="Bc.">Bc.</option>
            </select>
            <label for="submit">confirm adding:</label>
            <input type="submit" value="Add" name="submit" id="submit">
    </form><br>
    <form action="" method="post" enctype="multipart/form-data">
    <label for="upload">upload bulk of users from excel sheet</label>
    <input type="file" name="excel" id="file">
    <input type="submit" value="Upload" name="upload" id="upload"><br>
    </form>
    
    <p>you can download a file template and fill it:</p>
    <a href="./img/temp.xlsx">Download Template</a>
</section>

</section>

<?php include("./inc/footer.php");?>