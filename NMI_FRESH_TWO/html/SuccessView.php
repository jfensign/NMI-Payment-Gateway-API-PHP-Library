<?php 

if(empty($_SESSION)) session_start();

?>
<div id="success_div">
<h2>Your payment was successfully processed.</h2>
	<a href="#view_receipt">View Your Receipt</a>
	<a href="#to_csv">Create CSV</a>
	<a href="#new_payment">Make Another Donation</a>
</div>
	
<style type="text/css">

#success_div {
	width: 350px;
	margin-left: auto;
	margin-right: auto;
	text-align: center;
	margin-top: 15px;
}

a {
	cursor: pointer;
	font-family: Helvetica,arial,freesans,clean,sans-serif;
	font-size: 11px;
	font-weight: bold;
	color: #551A8B;
	text-shadow: 1px 1px 0 white;
	white-space: nowrap;
	float: left;
	margin-right: 15px;
	padding: 0;
	margin-bottom: 20px;
	text-decoration: none;
}
  
h2 {

margin: 0;
border-top-left-radius: 1px;
border-top-right-radius: 1px;
border: 1px solid #D8D8D8;
border-bottom: 1px solid #CCC;
padding: 10px 10px 11px 10px;
font-size: 14px;
font-family: Helvetica, Arial, freesans, clean, sans-serif;
text-shadow: 0 1px 0 white;
}
  
</style>