<?php
include "utilities/helpers.php";

// connect to server
$conn = connect();

$alert = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $action = $_POST['action'] ?? "nothing";

    if ($action == 'add') {
        // get values
        $name = $_POST['fname'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $postal = $_POST['postal'];
        $type = $_POST['type'];
        $capacity = $_POST['capacity'];
        $phone = $_POST['phone'];
        $website = $_POST['website'];

        $query1 = "insert into Region(PostalCode, City, Province) values(?,?,?)";
        $query2 = "insert into Facilities(FName, FAddress, PostalCode, Type, Capacity, Phone, Website) values(?,?,?,?,?,?,?)";


        // prepare query
        $stmt1 = mysqli_prepare($conn, $query1); 
        $stmt2 = mysqli_prepare($conn, $query2); 

        // bind query with chosen facility id
        mysqli_stmt_bind_param($stmt1, 'sss', $postal, $city, $province);
        mysqli_stmt_bind_param($stmt2, 'ssssiss', $name, $address, $postal, $type, $capacity, $phone, $website);
        
        // execute query
        $success1 = mysqli_stmt_execute($stmt1);
        $success2 = mysqli_stmt_execute($stmt2);

        if($success1 and $success2 ) {
            $alert = "Added succesfully!";
        }
        else {
            $alert = "Unable to add. Error occured!";
        }
    }
    else if ($action == "delete") {
        // get values
        $fid = $_POST['fid'];
        
        // prepare query
        $stmt = mysqli_prepare($conn, "DELETE FROM Facilities Where FID = ?;");
        
        mysqli_stmt_bind_param($stmt, 's', $fid);

        // execute query
        $success = mysqli_stmt_execute($stmt);

        if($success) {
            $alert = "Deleted succesfully!";
        }
        else {
            $alert = "Unable to delete. Error occured!";
        }
    }
    else if ($action == "update") {
        $fid = $_POST['fid'];
        $name = $_POST['fname'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $postal = $_POST['postal'];
        $type = $_POST['type'];
        $capacity = $_POST['capacity'];
        $phone = $_POST['phone'];
        $website = $_POST['website'];

        $query1 = "insert into Region(PostalCode, City, Province) VALUES(?,?,?) on duplicate key update PostalCode = ?, City = ?, Province = ?";
        $query2 = "update Facilities set FName = ?, FAddress = ?, PostalCode = ?, Type = ?, Capacity = ?, Phone = ?, Website = ? where FID = ?";

        // prepare query
        $stmt1 = mysqli_prepare($conn, $query1); 
        $stmt2 = mysqli_prepare($conn, $query2); 

        // bind query with chosen facility id
        mysqli_stmt_bind_param($stmt1, 'ssssss', $postal, $city, $province, $postal, $city, $province);
        mysqli_stmt_bind_param($stmt2, 'ssssissi', $name, $address, $postal, $type, $capacity, $phone, $website, $fid);
        
        // execute query
        $success1 = mysqli_stmt_execute($stmt1);
        $success2 = mysqli_stmt_execute($stmt2);

        if($success1 and $success2 ) {
            $alert = "Updated succesfully!";
        }
        else {
            $alert = "Unable to update. Error occured!";
        }

        // send alert to javascript as json
        $data = [
            "alert" => $alert
        ];
        echo json_encode($data);
        exit;
    }
} 

    // query result
    $result = mysqli_query($conn, "SELECT * from Facilities f JOIN Region r ON r.PostalCode = f.PostalCode"); 

    // result to array
    $records = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // disconnect from server
    disconnect($conn);
    
    render("facilities.php", ["title" => "Facilities", "records" => $records, "alert" => $alert]);

?>