<head>
    <title>Preview</title>
    <?php 
        if (isset($_POST['submit'])) {
            $subcat = $_POST['subcat'];
            $loc = $_POST['loc'];
            $title = $_POST['title'];
            $price = $_POST['price'];
            $desc = $_POST['desc'];

            // Verify data
            if (!strcmp($subcat, "Please select")) {
                $valid_subcat = false;
            } else {
                $valid_subcat = true;
            }
            if (!strcmp($loc, "Please select")) {
                $valid_loc = false;
            } else {
                $valid_loc = true;
            }
            if (preg_match("/^\s+$/", $title)) {
                $valid_title = false;
            } else if (preg_match("/.+/", $title)) {
                $valid_title = true;
            } else {
                $valid_title = false;
            }
            if (preg_match("/\d+/", $price)) {
                $valid_price = true;
            } else {
                $valid_price = false;
            }
            if (preg_match("/^\s*$/", $desc)) {
                $valid_desc = false;
            } else {
                $valid_desc = true;
            }

            if (isset($_POST['agree'])) {
                $agree = true;
            } else {
                $agree = false;
            }
        }
        if (isset($_POST['submit'])) {
            $valid_img1 = false;
            $valid_img2 = false;
            $valid_img3 = false;
            $valid_img4 = false;
            $xml = new SimpleXMLElement('<post></post>');

            // Verify image
            if ($_FILES['img1']['tmp_name'] != "" && getimagesize($_FILES['img1']['tmp_name']) == true) {
                $valid_img1 = true;
                $img1 = addslashes($_FILES['img1']['tmp_name']);
                $img1_name = addslashes($_FILES['img1']['name']);
                $img1_size = addslashes($_FILES['img1']['size']);
                $img1 = file_get_contents($img1);
                $img1 = base64_encode($img1);
            }
            if ($_FILES['img2']['tmp_name'] != "" && getimagesize($_FILES['img2']['tmp_name']) == true) {
                $valid_img2 = true;
                $img2 = addslashes($_FILES['img2']['tmp_name']);
                $img2_name = addslashes($_FILES['img2']['name']);
                $img2_size = addslashes($_FILES['img2']['size']);
                $img2 = file_get_contents($img2);
                $img2 = base64_encode($img2);
            }
            if ($_FILES['img3']['tmp_name'] != "" && getimagesize($_FILES['img3']['tmp_name']) == true) {
                $valid_img3 = true;
                $img3 = addslashes($_FILES['img3']['tmp_name']);
                $img3_name = addslashes($_FILES['img3']['name']);
                $img3_size = addslashes($_FILES['img3']['size']);
                $img3 = file_get_contents($img3);
                $img3 = base64_encode($img3);
            }
            
        }
    ?>
</head>
<body>
    <?php
        session_start();
        $email = $_SESSION['email'];
        $post_id = $_GET['postid'];
        // Store data as XML file for read by post data page
        function writeDataAsXML() {
            global $title, $price, $desc, $email , $subcat, $loc;
            global $valid_img1, $valid_img2, $valid_img3;

            $xml = new SimpleXMLElement('<post></post>');
            $xml->addChild('title', $title);
            $xml->addChild('price', $price);
            $xml->addChild('desc', $desc);
            $xml->addChild('email', $email);
            $xml->addChild('subcat_id', $subcat);
            $xml->addChild('loc_id', $loc);
            
            if ($valid_img1) {
                global $img1;
                $xml->addChild('img1', $img1);
            }
            if ($valid_img2) {
                global $img2;
                $xml->addChild('img2', $img2);
            }
            if ($valid_img3) {
                global $img3;
                $xml->addChild('img3', $img3);
            }
            $xml->asXML('postdata.xml');
        }
        $isValidData = true;
        if (!$valid_subcat) {
            echo "<span style='color: red;'>Please select one Sub-Category!</span><br>";
            $isValidData = false;
        }
        if (!$valid_loc) {
            echo "<span style='color: red;'>Please select one location!</span><br>";
            $isValidData = false;
        }
        if (!$valid_title) {
            echo "<span style='color: red;'>Please provide title!</span><br>";
            $isValidData = false;
        }
        if (!$valid_price) {
            echo "<span style='color: red;'>Please provide correct price!</span><br>";
            $isValidData = false;
        }
        if (!$valid_desc) {
            echo "<span style='color: red;'>Description can't be empty!</span><br>";
            $isValidData = false;
        }
        if (!$agree) {
            echo "<span style='color: red;'>You don't agree terms!</span><br>";
            $isValidData = false;
        }
        
        // Check image size. It should be <= 5MB
        if ($valid_img1 && $img1_size > 5242880) {
            echo "<span style='color: red;'>Max image size is 5 MB</span><br>";
            $img1_size_d = $img1_size / 1024.0 / 1024.0;
            $img1_size_d = round($img1_size_d, 2);
            echo "<span style='color: red;'>Your image size is $img1_size_d MB</span><br>";
            $isValidData = false;
        }
        if ($valid_img2 && $img2_size > 5242880) {
            echo "<span style='color: red;'>Max image size is 5 MB</span><br>";
            $img2_size_d = $img2_size / 1024.0 / 1024.0;
            $img2_size_d = round($img2_size_d, 2);
            echo "<span style='color: red;'>Your image size is $img2_size_d MB</span><br>";
            $isValidData = false;
        }
        if ($valid_img3 && $img3_size > 5242880) {
            echo "<span style='color: red;'>Max image size is 5 MB</span><br>";
            $img3_size_d = $img3_size / 1024.0 / 1024.0;
            $img3_size_d = round($img3_size_d, 2);
            echo "<span style='color: red;'>Your image size is $img3_size_d MB</span><br>";
            $isValidData = false;
        }
        if ($isValidData) {
            echo "<h2>Please review the following informaiton</h2>";
            echo "<p>Sub-Category: "; 
            echo htmlspecialchars($subcat);
            echo "</p>";
            echo "<p>Location: "; 
            echo htmlspecialchars($loc);
            echo "</p>";
            echo "<p>Title: "; 
            echo htmlspecialchars($title);
            echo "</p>";
            echo "<p>Price: "; 
            echo (int)($price);
            echo "</p>";
            echo "<p>Description: "; 
            echo htmlspecialchars($desc);
            echo "</p>";
            if ($valid_img1) {
                echo "<p> image 1: ";
                echo $img1_name;
                echo "</p>";
            }
            if ($valid_img2) {
                echo "<p> image 2: ";
                echo $img2_name;
                echo "</p>";
            }
            if ($valid_img3) {
                echo "<p> image 3: ";
                echo $img3_name;
                echo "</p>";
            }
            writeDataAsXML();
            echo "<p><form action='updatedata.php?postid=$post_id' method ='POST'>";
            echo "<input type='submit' value='submit'>";
            echo "<input type='button' value='Back' onClick='history.go(-1);'>";
            echo "</form></p>";
        } else {
            echo "<input type='button' value='Back' onClick='history.go(-1);'>";
            return;
        }
    ?>
</body>
