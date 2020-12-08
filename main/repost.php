<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <?php 

        $post_id = $_GET['postid'];
        //
        // Connect to MySQL server
        //
        $DBServer = 'localhost';
        $DBUser = 'root';
        $DBPasswd = 'root';
        $DBName = 'wpl_final_project';
        $conn = new mysqli($DBServer, $DBUser, $DBPasswd, $DBName);
        if ($conn->connect_error) {
            trigger_error('Database connection failed: ' .  $conn->connect_error, E_USER_ERROR);
        }
        //
        //Select the post result
        //
        $sql = "SELECT * FROM Posts WHERE Post_ID = '$post_id' ";
        $rs = $conn->query($sql);
        if ($rs === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
        }
        //echo $rows_returned = $rs->num_rows;
        $row = $rs->fetch_assoc();
        $title = $row['Title'];
        $price = $row['Price'];
        $price_int = (int)$price;
        $desc = $row['Description'];
        $email = $row['Email'];
        $agree = $row['Agreement'];
        $ts = $row['TimeStamp'];
        $img1 = $row['Image_1'];
        $img2 = $row['Image_2'];
        $img3 = $row['Image_3'];
        $subcat_id = $row['SubCategory_ID'];
        $loc_id = $row['Location_ID'];
        //
        // Insert data
        //
        $sql = "INSERT INTO Posts (Title, Price, Description, Email, Agreement, Image_1, Image_2, Image_3, SubCategory_ID, Location_ID) VALUES ('$title', $price_int, '$desc', '$email', '$agree', '$img1', '$img2', '$img3', '$subcat_id', '$loc_id') ";
        //echo $sql;
        if (mysqli_query($conn, $sql)) {
            //echo "success";
            $last_inserted_id = $conn->insert_id;
            $affected_rows = $conn->affected_rows;
            } 
        else {
            //trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        // Close MySQL connection
        //$conn->close();
        mysqli_close($conn);
        //
        //Redirect page to settings.php
        //
        header('location:settings.php');

    ?>
</body>
</html>
        