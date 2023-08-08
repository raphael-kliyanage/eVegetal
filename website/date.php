<?php

include ("db_connect.php");

$response1=array();
//Table Date
$req1=mysqli_query($cnx, " select * from Date ");

if(mysqli_num_rows($req1) > 0)
{
	//création d'un tableau temporaire
	$tmp1=array();
	$response1["users1"]=array();

	while($cur1=mysqli_fetch_array($req1))
	{
		$tmp1["ID"]=$cur1["ID"];
		$tmp1["date"]=$cur1["date"];

		array_push($response1["users1"], $tmp1);
	}
	$response1["success"]=1;
	echo json_encode($response1);
}	

?>
