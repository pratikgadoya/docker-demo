<?php
// include("Connection/conn.php");

$con = mysqli_connect("localhost", "root", "root", "dockerdemo");

$qry = mysqli_query($con, "select * from users order by id desc");
$cate = $_REQUEST['cat'];

// ========================================= Insert Record ================================
if (isset($_REQUEST['ins'])) {
    $name = $_REQUEST['name'];
    $userName = $_REQUEST['uname'];
    $email = $_REQUEST['email'];
    $pass = $_REQUEST['pass'];
    $mobile = $_REQUEST['mobile'];
    $categories = $_REQUEST['cat'];

    $qry = mysqli_query($con, "insert into users (name,userName,email,password,mobile,categories) values ('$name','$userName','$email','$pass','$mobile','$categories')");
    if ($qry) {
        ?>
			<script>
				alert("Data inserted...");
			</script>
			<?php
    } else {
        ?>
			<script>
				alert("Data Not inserted...");
			</script>
			<?php
    }
}

//  ============================================== Delete Records ===============================
if (isset($_REQUEST['del'])) {
    $id = $_REQUEST['id'];

    $qry = mysqli_query($con, "delete from users where id='$id'");
    if ($qry) {
        ?>
		<script>
			alert("Record Deleted...");
		</script>
		<?php
    }
}

// =============================================== Edit Recods ==================================

if (isset($_REQUEST['edit'])) {

    $id = $_REQUEST[id];
    $name = $_REQUEST[name];
    $uname = $_REQUEST[uname];
    $email = $_REQUEST[email];
    $pass = $_REQUEST[pass];
    $mobile = $_REQUEST[mobile];
    $categories = $_REQUEST[cat];

    $qry = mysqli_query($con, "update users set name='$name',userName='$uname',email='$email',password='$pass',mobile='$mobile',categories='$categories' where id='$id'");

    if ($qry) {
        ?>
				<script>
					alert("Record Updated...");
				</script>
			<?php
    } else {
        ?>
				<script>
					alert("Record not Updated...");
				</script>
			<?php
    }
}

//  ======================================== Categories ====================================

if ($cate != "" || $cate != null) {
    $qry = mysqli_query($con, "select * from users where categories='$cate' order by id desc");
}

// =======================================DELETE SELECTED====================================

if (isset($_REQUEST['delsel'])) {
    $sel = $_REQUEST['sel'];
    $query = mysqli_query($con, "delete from users where id in($sel)");
    if ($query) {
        ?>
				<script>
						alert("Record Successfully Deleted");
				</script>
				<?php
}
}

//  ================================== For Edit Data======================================

if (isset($_REQUEST[getedit])) {
    $id = $_REQUEST[id]; // get id for edit
    $editQry = mysqli_query($con, "select * from users where id='$id'");

    $editData = mysqli_fetch_array($editQry);
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Data Table</title>
	<link rel="stylesheet" href="css/data-tables.css"/>
	<script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/data-tables.js"></script>


    <script herf="//code.jquery.com/jquery-1.12.4.js"></script>
    <script href="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script href="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>


    <script type="text/javascript" src="js/reg.js"></script>

</head>
<body onload="tbl()">
<!-- =============================== Registration Form ============================= -->
<form name="myform" method="POST">
	<h1 align="center">Register Here</h1>
	<tr>
			<td><input type="hidden" name="id" id="id" value="<?php echo $editData[id]; ?>"></td>
		</tr>
		<table align="center">

		<tr>
			<td>Name : </td>
			<td><input type="text" name="name" id="nm" value="<?php echo $editData[name]; ?>"></td>
		</tr>

		<tr>
			<td>User Name : </td>
			<td><input type="text" name="uname" id="unm" value="<?php echo $editData[userName]; ?>"></ins></td>
		</tr>

		<tr>
			<td>Email : </td>
			<td><input type="Email" name="email" id="mail" value="<?php echo $editData[email]; ?>"></td>
		</tr>

		<tr>
			<td>Password : </td>
			<td><input type="Password" name="pass" id="pass" value="<?php echo $editData[password]; ?>"></td>
		</tr>

		<tr>
			<td>Confirm Password : </td>
			<td><input type="Password" name="cpass" id="cpass" value="<?php echo $editData[password]; ?>"></td>
		</tr>

		<tr>
			<td>Mobile : </td>
			<td><input type="text" name="mobile" id="mob" maxlength="10" value="<?php echo $editData[mobile]; ?>"></td>
		</tr>

		<tr>
			<td>Categories : </td>
			<td><input type="text" name="categories" id="cat" style="text-transform: uppercase;" value="<?php echo $editData[categories]; ?>"></td>
		</tr>

		<tr>
			<?php
if (isset($id)) {
    ?>
						<td align="right"><input type="button" name="update" value="Update" onclick="validation();"></td>
						<td align="left"><input type="button" value="Cancel" onclick="resetall()"></td>
					<?php
} else {
    ?>
						<td align="right"><input type="button" name="save" value="Insert" onclick="validation();"></td>
						<td align="left"><input type="reset" name="cancel" value="Cancel" onclick="resetall();"></td>
					<?php
}
?>
		</tr>
	</table>
	<br>
	<div align="center" style="color: red; height: 20px" id="error"></div>
</form>


<!-- ============================================= Display Data from database ================================ -->


<form name="Didsplay-data" method="POST">
	<h1 align='center'>User Details</h1>
	<table id="mytable" class="display">
	<!-- <center>
		<select onchange="categories(this.value,'<?php echo $limit; ?>','<?php echo $srch; ?>')">
			<option style="display: none;"><?php echo $cate; ?></option>
			<?php if ($cate == "" || $cate == null) {?>
				<option value="" selected>All</option>
			 <?php } else {?>
				<option value="">All</option>
			<?php }?>
			<?php
$catquery = mysqli_query($con, "select * from users");
while ($cat = mysqli_fetch_assoc($catquery)) {
    $catdata[] = $cat[categories];
}

$catdata = array_unique($catdata);
$catlength = count($catdata);
$catdata = implode(",", $catdata);
$catdata = explode(",", $catdata);
sort($catdata);

foreach ($catdata as $categories) {?>
				<option value="<?php echo $categories; ?>"><?php echo $categories; ?></option>

			<?php }?>
		</select>
	</center>
 -->		<thead>
			<th><input type="checkbox" name="select_all" id="selall" value="1"></th>
			<th>ID</th>
			<th>Name</th>
			<th>User Name</th>
			<th>Email</th>
			<th>Password</th>
			<th>Mobile</th>
			<th>Categories</th>
			<th>Action</th>
		</thead>

		<tbody>
			<?php while ($data = mysqli_fetch_array($qry)) {?>
				<tr>
					<td></td>
					<td><?php echo $data[id]; ?></td>
					<td><?php echo $data[name]; ?></td>
					<td><?php echo $data[userName]; ?></td>
					<td><?php echo $data[email]; ?></td>
					<td><?php echo $data[password]; ?></td>
					<td><?php echo $data[mobile]; ?></td>
					<td><?php echo $data[categories]; ?></td>
					<td></td>
				</tr>

			<?php }?>
		</tbody>
		<tfoot>
			<td id="prevpage" colspan="4" align="left"></td>
			<td id="del" colspan="2" align="center"></td>
			<td id="nextpage" colspan="3" align="right"></td>
		</tfoot>
	</table>
</form>
</body>
</html>