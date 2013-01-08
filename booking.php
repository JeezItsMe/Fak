<?php 
include_once("./includes/DbConnection.php");
$rsIns = false;
$inputError = true;
$errorBooking = array("customerName" => "", "customer_MobileNumber" => "", "customerEmailAddresss" => "", "bookedDate" => "",);
if(isset($_POST["isBooked"])) {
	if(empty($_POST['customerName'])) {
		$errorBooking["customerName"] = " Please enter your name.";
		$inputError = false;
	}
	if(empty($_POST['customer_MobileNumber']) || !is_numeric($_POST['customer_MobileNumber']) || strlen($_POST['customer_MobileNumber']) != 11) {
		$errorBooking["customer_MobileNumber"] = " Please enter your correct mobile number.";
		$inputError = false;
	}
	if(empty($_POST['bookedDate'])) {
		$errorBooking["bookedDate"] = " Please enter the date from calendar.";
		$inputError = false;
	}
	else {
		$postedDate = $_POST['bookedDate'];
		if(substr_count($postedDate,'-') == 2)
		{
			list($m,$d,$y) = explode('-',$postedDate);
			if(is_numeric($m) && is_numeric($d) && is_numeric($y)) {
				if(!checkdate($m,$d,$y)) {
				$errorBooking["bookedDate"] = " Please enter the date from calendar.";
				$inputError = false;
				}
			}
			else {
				$errorBooking["bookedDate"] = " Please enter the date from calendar.";
				$inputError = false;
			}
			
		}
		else { 
			$errorBooking["bookedDate"] = " Please enter the date from calendar.";
			$inputError = false;
		} 
	}
	if (!filter_var($_POST['customerEmailAddresss'], FILTER_VALIDATE_EMAIL)) {
		$errorBooking["customerEmailAddresss"] = " Please enter your valid email address.";
		$inputError = false;
	}
		// just for testing
		/*  $emailId = "khem.thapa15@gmail.com";
		$subject = "Booking Request for (Fakrudding Biryani House) From ".$_POST['customerName'];
		$header = "Content-type: text/html;" . "\r\n";
		$header .= "From:".$_POST['customerEmailAddresss'];
		$message = "<table>
					<tr><td width='170'><img src='http://kt.bugs3.com/fakruddin/images/logo.png' /></td></tr>
					<tr><td width='170' height='20'>&nbsp;</td></tr>
					<tr><td width='170'>Customer Name: </td><td>".$_POST['customerName']."</td></tr>
					<tr><td width='170'>Customer Mobile Number: </td><td>".$_POST['customer_MobileNumber']."</td></tr>
					<tr><td width='170'>Customer Email Address: </td><td>".$_POST['customerEmailAddresss']."</td></tr>
					<tr><td width='170'>Booking Date: </td><td>".$_POST['bookedDate']."</td></tr>
					<tr><td width='170'>Boo ing Time: </td><td>".$_POST['bookedTime']."</td></tr>
					<tr><td width='170'>Number of Persons: </td><td>".$_POST['customerQuantity']."</td></tr>
					</table>";
		mail($emailId, $subject, $message, $header); */
	if($inputError):
		$insObj = new DbConnection();
		$insObj->connect_db();
		$cnt = $insObj->selectDb_count("tbl_bookings", array("bookedDate" => $_POST['bookedDate'], "bookedTime" => $_POST['bookedTime']));
		if($cnt == 0 ) { // start of cnt
			$rsIns = $insObj->insertDb("tbl_bookings",$_POST);
			if($rsIns) {
				$emailId = "khem.thapa15@gmail.com";
				$subject = "Booking Request for (Fakrudding Biryani House) From ".$_POST['customerName'];
				$header = "Content-type: text/html;" . "\r\n";
				$header .= "From:".$_POST['customerEmailAddresss'];
				$message = "<table>
							<tr><td width='170'><img src='http://kt.bugs3.com/fakruddin/images/logo.png' /></td></tr>
							<tr><td width='170' height='20'>&nbsp;</td></tr>
							<tr><td width='170'>Customer Name: </td><td>".$_POST['customerName']."</td></tr>
							<tr><td width='170'>Customer Mobile Number: </td><td>".$_POST['customer_MobileNumber']."</td></tr>
							<tr><td width='170'>Customer Email Address: </td><td>".$_POST['customerEmailAddresss']."</td></tr>
							<tr><td width='170'>Booking Date: </td><td>".$_POST['bookedDate']."</td></tr>
							<tr><td width='170'>Boo ing Time: </td><td>".$_POST['bookedTime']."</td></tr>
							<tr><td width='170'>Number of Persons: </td><td>".$_POST['customerQuantity']."</td></tr>
							</table>";
				if(mail($emailId, $subject, $message, $header)) {
					$noteMesage = "Thank you. This is just the Note for your booking Request. Your Email has been sent successfully.";
				}
				else {
					$noteMesage = "Thank you. This is just the Note for your booking Request. Your Email hasnot been sent.";
				}
				
			}
		} // end of cnt
		else { 
		$rsIns = true; $noteMesage = "Sorry, there is no table available for the date and time you requested. Please call us for any adjustment or rebook wwith the changed date and time. Thank you."; 
		}
		$insObj->close_db();
	endif; // if the form is error free
 }
 

?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta name="description" content="fakruddin biryani"/>
		<meta name="keywords" content="biryani, restaurant, whitechapel, fakruddin" />
		<title>Home - Fakruddin Biryani</title>
		<link rel="stylesheet" href="./css/styles.css" type="text/css" />
		<!--[if lt IE 9]><script src="dist/html5shiv.js"></script><![endif]-->
		<script type="text/javascript" src="js/jquery-1.3.1.min.js"></script>
		<script type="text/javascript" src="javascript/bannerSlider.js"></script>
		<link rel="stylesheet" type="text/css" media="all" href="jsDatePicker/jsDatePick_ltr.min.css" />
		<script type="text/javascript" src="jsDatePicker/jsDatePick.min.1.3.js"></script>
		<script>
		var d = new Date();
		if((d.getMonth()+1) == 13) { selMonth = 1;} else { selMonth = d.getMonth()+1; }
		window.onload = function(){
				new JsDatePick({
					useMode:2,
					target:"bookedDate",
					dateFormat:"%m-%d-%Y",
					selectedDate:{				
						day:d.getDate(),						
						month:selMonth,
						year:d.getFullYear()
					},
					/*
					yearsRange:[1978,2020],
					limitToToday:false,
					cellColorScheme:"beige",
					dateFormat:"%m-%d-%Y",
					imgPath:"img/",
					weekStartDay:1*/
				});
			};

		</script>
	</head><!-- End Head -->

<body>
	<div id="wrapper">
		<header>
		<img id="logo" src="images/logo.png">
		<div id="headerContact">
			<img style="vertical-align: middle" src="images/78.png"> 0207  536  291 <br />
			<img style="vertical-align: middle" src="images/31.png"> <a href="mailto:contact@fakruddinbiryani.co.uk">contact@fakruddinbiryani.co.uk</a>
		</div>
		<ul id="nav">
			<li id="liHome"><a href="index.php">Home</a></li>
			<li id="liAbout"><a href="#">About Us</a></li>
			<li id="liMenu"><a href="#">Menu</a></li>
			<li id="liBooking"><a href="booking.php">Booking</a></li>
			<li id="liContact"><a href="#">Contact Us</a></li>
		</ul>
		</header> 
		
		<!-- End Header -->
		
		<div id="content">
			<div style="clear:both;">
			<div id="gallery" >
				<a href="#" class="show">
					<img src="images/sliderImages/chocolate.png" alt="chocolate"  title="Flowing Rock" rel="" border="0"/>
				</a>
				
				<a href="#">
					<img src="images/sliderImages/steak.png" alt="steak" title="" rel="" border="0"/>
				</a>
				
				<a href="#">
					<img src="images/sliderImages/noodles.png" alt="noodles"  title="" rel="" border="0"/>
				</a>
				
					<a href="#">
					<img src="images/sliderImages/pizza.png" alt="pizza"  title="" rel="" border="0"/>
				</a>
				
					<a href="#">
					<img src="images/sliderImages/samosa.png" alt="samosa"  title="" rel="" border="0"/>
				</a>
			</div> <!-- end of gallery -->
			</div>
		<div id="container">
			
			<div id="sig_dishes">
			<h2>Fakruddin</h2>
			<div style="padding-top:12px;">
				<img class="sig_bullets" src="images/65.png" />  Kacchi Biryani <br />
				<img class="sig_bullets"  src="images/65.png" />  Chicken Biryani <br />
				<img class="sig_bullets"  src="images/65.png" />  Jaai Kebab <br />
				<img class="sig_bullets"  src="images/65.png" />  Borhani <br />
				</div>
			</div>
			
			<div id="welcome">
			<h2>Book Table</h2>
			<?php if($rsIns) {
			echo $noteMesage;
			} else { ?>
			<form name="bookingForm" id="bookingForm" method="post" onsubmit="return validateForm(this)">
			<div id="bookTable" style="padding:10px;">
			<p>
			Your Name: <br/ >
			<input type="text" size="33" id="customerName" name="customerName" value="<?php if(isset($_POST['customerName'])){echo $_POST['customerName'];}?>" /> <?php if(!empty($errorBooking["customerName"])){echo $errorBooking["customerName"];}?>
			</p>
			
			<p>
			Your Mobile Number: <br/ >
			<input type="text" size="33" id="customer_MobileNumber" name="customer_MobileNumber" MAXLENGTH="11" value="<?php if(isset($_POST['customer_MobileNumber'])) { echo $_POST['customer_MobileNumber'];}?>" /><?php if(!empty($errorBooking["customer_MobileNumber"])){echo $errorBooking["customer_MobileNumber"];}?>
			</p>
			
			<p>
			Your Email: <br/ >
			<input type="text" size="33" id="customerEmailAddresss" name="customerEmailAddresss"  value="<?php if(isset($_POST['customerEmailAddresss'])){ echo $_POST['customerEmailAddresss'];}?>"/><?php if(!empty($errorBooking["customerEmailAddresss"])){echo $errorBooking["customerEmailAddresss"];}?>
			</p>
			
			<p>
			Date: <br/ >
			<input type="text" size="12" id="bookedDate" name="bookedDate" value="<?php if(isset($_POST['bookedDate'])) { echo $_POST['bookedDate'];}?>"/><?php if(!empty($errorBooking["bookedDate"])){echo $errorBooking["bookedDate"];}?>
			</p>
			
			<p>
			Time: <br/ >
			<select id="bookedTime" name="bookedTime">
  			<option value="11:00" selected>11:00</option>
			<option value="12:00">12:00</option>
			<option value="13:00">13:00</option>
			<option value="14:00">14:00</option>
			<option value="15:00">15:00</option>
			<option value="16:00">16:00</option>
			<option value="17:00">17:00</option>
			<option value="18:00">18:00</option>
			<option value="19:00">19:00</option>
			<option value="20:00">20:00</option>
			<option value="21:00">21:00</option>
			<option value="22:00">22:00</option>
			</select>
			</p>
			
			<p>
			No. Of Person: <br/ >
			<select id="customerQuantiy" name="customerQuantity">
  			<option selected>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
			<option>6</option>
			</select>
			</p>
			
			<p>
			<input  id="isBooked" name="isBooked" type="submit" value="Book" class="" />
			<input type="hidden" name="customer_ipAddress" id="customer_ipAddress" value="<?php echo $_SERVER['REMOTE_ADDR']?>"/>
			<input type="hidden" name="requestedDate" id="requestedDate" value="<?php echo gmdate("Y-m-d H:i:s");  ?>" />
			</p>
			
			</div>
			</form>
			<?php }?>
			</div>
			
			<div id="services">
				<h2>Services</h2>
			</div>
			<div id="reviews">
				<h2>Customer Reviews</h2>
			</div>
		</div>
		</div> 
		
		<!-- End Content -->
		
		<footer><p>&copy;2012 fakruddinbiryani.co.uk</p></footer>
	</div> <!-- End Wrapper -->
</body> <!-- End Body -->
</html>


