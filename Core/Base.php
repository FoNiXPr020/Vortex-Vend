<?php

function assets($path)
{
	$path = trim($path, " \t\n\r\0\x0B./");
	$path = str_replace('\\', '/', $path);
	echo '/assets/' . $path;
}

function PaypalBase() {
	if ($_ENV['PAYPAL_MODE'] == "live") {
		$base = "https://api-m.paypal.com";
	} else if ($_ENV['PAYPAL_MODE'] == "sandbox") {
		$base = "https://api-m.sandbox.paypal.com";
	}
	return $base;
}

function PaypalCheckoutNow() {
	if ($_ENV['PAYPAL_MODE'] == "live") {
		$base = "https://www.paypal.com/checkoutnow";
	} else if ($_ENV['PAYPAL_MODE'] == "sandbox") {
		$base = "https://www.sandbox.paypal.com/checkoutnow";
	}
	return $base;
}

function displayToast($type, $messages)
{
	echo "<script>";
	echo "const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3000,
		timerProgressBar: true,
		didOpen: (toast) => {
		  toast.addEventListener('mouseenter', Swal.stopTimer)
		  toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	  });";
	foreach ($messages as $message) {
		echo "Toast.fire({
			icon: '$type',
			title: '$message'
		});";
	}
	echo "</script>";
}