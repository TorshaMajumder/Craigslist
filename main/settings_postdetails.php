<!DOCTYPE html>
<html>
<head>
    <link href="css/slide_pic.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="js/slideshow.js"></script>
    <style>
        #results {
            font-size: 16px;

        }
        #img-show {
            padding: 30px;
    	    margin: 0 auto;
        }
        #pre-back-btn {
            padding-left: 100px;
        }
        #back-btn {
            max-width: 210px;
        }
        .mySlides {
            display:none;
            text-align: center;
        }
        img.displayed {
        display: block;
        margin-left: auto;
        margin-right: auto 
        }
    </style>
    <?php 
        if (isset($_POST['submit'])) {
            header('location:postlists.php');
        }
    ?>
</head>
<body>
    <?php
        session_start();
        $username = $_SESSION['username'];
        $post_id = $_GET['postid'];
        // Connect to MySQL server
        $DBServer = 'localhost';
        $DBUser = 'root';
        $DBPasswd = 'root';
        $DBName = 'wpl_final_project';
        $conn = new mysqli($DBServer, $DBUser, $DBPasswd, $DBName);
        if ($conn->connect_error) {
            trigger_error('Database connection failed: ' .  $conn->connect_error, E_USER_ERROR);
        }
        // Look up all posts
        $sql = "SELECT * FROM Posts JOIN SubCategory JOIN Category JOIN Location JOIN Region ON Post_ID=" . $post_id . " AND Posts.SubCategory_ID=SubCategory.SubCategory_ID AND SubCategory.Category_ID=Category.Category_ID AND Posts.Location_ID=Location.Location_ID AND Location.Region_ID=Region.Region_ID";
        $rs = $conn->query($sql);
        if ($rs === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
        }
        $row = $rs->fetch_assoc();
    ?>  

        <br>
        <br>
        <div class="w3-content w3-display-container">

        <?php 
                if (isset($row['Image_1'])) {
                    echo "<img class= 'mySlides displayed' style='width:250px;height:250px;' src='data:image;base64," . $row['Image_1'] . "'>";
                }
                if (isset($row['Image_2'])) {
                    echo "<img class= 'mySlides displayed' style='width:250px;height:250px' src='data:image;base64," . $row['Image_2'] . "'>";
                }
                if (isset($row['Image_3'])) {
                    echo "<img class= 'mySlides displayed' style='width:250px;height:250px' src='data:image;base64," . $row['Image_3'] . "'>";
                }
                
            ?>
            
        <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
        <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
    </div>
        
<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}
</script>
   
        
    <?php
        echo "<div class='container' id='results'>";
        echo '<dl class="dl-horizontal">';
        echo "<dt>Author</dt>";
        echo "<dd>" . $username . "</dd>";
        echo "<dt>Category</dt>";
        echo "<dd>" . $row['CategoryName'] . " / " . $row['SubCategoryName'] . "</dd>";
        echo "<dt>Location</dt>";
        echo "<dd>" . $row['RegionName'] . " / " . $row['LocationName'] . "</dd>";
        echo "<dt>Title</dt>";
        echo "<dd>" . $row['Title'] . "</dd>";
        echo "<dt>Price($)</dt>";
        echo "<dd>" . $row['Price'] . "</dd>";
        echo "<dt>Email</dt>";
        echo "<dd>" . $row['Email'] . "</dd>";
        echo "<dt>Description</dt>";
        echo "<dd>" . $row['Description'] . "</dd>";
        echo "<dt>Post time</dt>";
        echo "<dd>" . $row['TimeStamp'] . "</dd>";
        echo "</dl>";
        echo "<div id='pre-back-btn'>";
        echo "<form action= 'settings.php' method='POST'>";
        echo "<input type='submit' class='btn btn-primary btn-block' id='back-btn'  value='&laquo;Back' name='submit'>";
        echo "</form>";
        echo "<form action= 'favlist.php' method='POST'>";
        echo "<p><a  id= 'fav' href='update.php?postid=$post_id' class='btn btn-primary' role='button'>Update</a></p>";
        echo "</form>";
        echo "<form action= 'delete.php' method='POST'>";
        echo "<p><a  id= 'fav' href='delete.php?postid=$post_id' class='btn btn-primary' role='button'>Delete</a></p>";
        echo "</form>";
        echo "<form action= 'repost.php' method='POST'>";
        echo "<p><a  id= 'fav' href='repost.php?postid=$post_id' class='btn btn-primary' role='button'>Repost</a></p>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
        
        $conn->close();
    ?>
</body>
</html>