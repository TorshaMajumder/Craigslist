<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <?php 
        session_start();
        $post_id = $_GET['postid'];
        // Get post data from xml file
        $file = "postdata.xml";
        $xml = simplexml_load_file($file);
        $title = $xml->title;
        $price = $xml->price;
        $desc = $xml->desc;
        $email = $xml->email;
        $subcat = $xml->subcat_id;
        $loc = $xml->loc_id;
        // Connect to MySQL server
        $DBServer = 'localhost';
        $DBUser = 'root';
        $DBPasswd = 'root';
        $DBName = 'wpl_final_project';
        $conn = new mysqli($DBServer, $DBUser, $DBPasswd, $DBName);
        if ($conn->connect_error) {
            trigger_error('Database connection failed: ' .  $conn->connect_error, E_USER_ERROR);
        }
        // Look up SubCategory_ID by Subcategory name
        $sql = "SELECT SubCategory_ID FROM SubCategory WHERE SubcategoryName = '$subcat'";
        $rs = $conn->query($sql);
        if ($rs === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
        }
        $rows_returned = $rs->num_rows;
        $rs->data_seek(0);
        $row = $rs->fetch_row();
        $subcat_id = $row[0];
        // Look up Location_ID by Location name
        $sql = "SELECT Location_ID FROM Location WHERE LocationName = '$loc'";
        $rs = $conn->query($sql);
        if ($rs === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
        }
        $rows_returned = $rs->num_rows;
        $rs->data_seek(0);
        $row = $rs->fetch_row();
        $loc_id = $row[0];

        // Update data
        $price_int = (int)$price;
        $sql = "UPDATE Posts SET Title = '$title', Price = '$price_int', Description = '$desc', Email = '$email', Agreement = '1', SubCategory_ID = '$subcat_id', Location_ID = '$loc_id'";
        // Handle images
        if (isset($xml->img1)) {
            $img1 = $xml->img1;
            $sql .= ", Image_1 = '$img1'";
        }
        if (isset($xml->img2)) {
            $img2 = $xml->img2;
            $sql .= ", Image_2 = '$img2'";
        }
        if (isset($xml->img3)) {
            $img3 = $xml->img3;
            $sql .= ", Image_3 = '$img3' ";
        }
        $sql .= " WHERE Post_ID = '$post_id';";
        
        if (mysqli_query($conn, $sql)) {
            //echo "success";
            $last_inserted_id = $conn->insert_id;
            $affected_rows = $conn->affected_rows;
            } 
        else {
            
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        
        // Close MySQL connection
        mysqli_close($conn);
        
        // Remove data from xml file
        unset($xml->title);
        unset($xml->price);
        unset($xml->desc);
        unset($xml->email);
        unset($xml->subcat_id);
        unset($xml->loc_id);
        if (isset($xml->img1)) {
            unset($xml->img1);
        }
        if (isset($xml->img2)) {
            unset($xml->img2);
        }
        if (isset($xml->img3)) {
            unset($xml->img3);
        }
        $xml->asXML('postdata.xml');
        
        // Redirect page to settings.php
        header('location:settings.php');
    ?>
</body>
</html>
