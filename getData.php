<?php

include 'config.php';

$data = json_decode(file_get_contents("php://input"));

## Values
$search = mysqli_real_escape_string($con,$data->searchText);	// Search value
$sortColumn = $data->sortColumn;	// Sort Column name
$sortOrder = $data->sortOrder; // Boolean value

$sortBy = "asc";
if($sortOrder){
	$sortBy = "desc";
}

## Select query
$select_emp = "select * from employees where 1 ";

if($search != ''){
	$select_emp .= " and (emp_name like '%".$search."%' OR 
		salary like '%".$search."%' OR
		gender like '%".$search."%' OR
		city like '%".$search."%' OR
		email like '%".$search."%')";
}

$select_emp .= " order by ".$sortColumn." ".$sortBy;

## Fetch records
$fetchRecords = mysqli_query($con,$select_emp);
$data = array();

while ($row = mysqli_fetch_array($fetchRecords)) {
	$data[] = array("emp_name" => $row['emp_name'],
	    "salary" => $row['salary'],
	    "gender" => $row['gender'],
	    "city" => $row['city'],
	    "email" => $row['email']
	);
}

echo json_encode($data);
