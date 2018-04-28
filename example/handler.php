<?php
	//Include class
    include '../links_grabber_class.php';

    //Creating an instance of a LinksGrabber class
	$LinksGrabber = new LinksGrabber($_GET["url"]);

	//Getting array with grabbed URLs
	$array_with_URLs = $LinksGrabber->URLs;

	echo json_encode($array_with_URLs);
	
?>