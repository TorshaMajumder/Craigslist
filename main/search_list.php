<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>BucketList</title>
    <link href="css/pagination.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/dropdown.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>
        body {
            padding-top: 60px;
            padding-left: 60px;
        }
        #graph {
            border: solid black 1px;
        }
        #intro {
            color: white;
        }
    </style>
</head>
<body>
    <?php 
        session_start();
        if (!$_SESSION['auth']) {
            header('location:postlists.php');
        }
        $username = $_SESSION['username'];
        $search = $_POST['search'];
        
    ?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="brand" href="newpost.php">BucketList</a>
                <div class="nav-collapse collapse">
                    <ul class="nav">
                        <li><a href="newpost.php">New</a></li>
                        <li><a href="postlists.php">Posts</a></li>
                    </ul>
                </div>
                <form class="navbar-form pull-right" action="logout.php">
                    <div class="form-group topnav search-container" id="intro">
                            <div style="display: inline;">
                            <?php echo "Hi $username&nbsp;&nbsp;"; ?>
                            </div>
                            <div style="display: inline;" class="dropdown">
                            <!--a class="brand" href="settings.php">Settings</a-->
                            <button class="dropbtn"><i class="fa fa-gear fa-spin" style="font-size:24px"></i></button>
                                <div class="dropdown-content">
                                    <a href="settings.php">Edit Posts</a>
                                    <a href="favlist_content.php">Favorites</a>
                                </div>
                                </div>
                            <div style="display: inline;">
                            <button type="submit" class="btn btn-success">Log out</button>
                            </div>
                        </div>
                </form>
                <form action="search_list.php" method="POST">
                        <input type="text" placeholder="Search by Name/Location" name="search">
                        <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <div class="row">
       <?php 
            // Connect to MySQL server
            $DBServer = 'localhost';
            $DBUser = 'root';
            $DBPasswd = 'root';
            $DBName = 'wpl_final_project';
            $conn = new mysqli($DBServer, $DBUser, $DBPasswd, $DBName);
            if ($conn->connect_error) {
                trigger_error('Database connection failed: ' .  $conn->connect_error, E_USER_ERROR);
            }
            $results_per_page = 2;
            // Look up all posts
            $sql = "SELECT * FROM Posts AS a , Location AS b WHERE (a.Location_ID = b.Location_ID AND ((a.Description LIKE '%$search%') OR (a.Title LIKE '%$search%') OR (b.zipcode LIKE '%$search%') OR (b.LocationName LIKE '%$search%'))) ORDER BY a.TimeStamp DESC";
            //echo $sql;
            $rs = $conn->query($sql);
            $number_of_results = $rs->num_rows;
            if($number_of_results == 0){
                echo "<p><h3>No result found!</h3></p>";
            }
            if ($rs === false) {
                trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
            }
            $number_of_pages = ceil($number_of_results/$results_per_page);
            if(!isset($_GET['page'])){$this_page_first_result = ($page -1) * $results_per_page;
                $page =1;
            } else{
                $page = $_GET['page'];
            }
            $this_page_first_result = ($page -1) * $results_per_page;
            $sql = "SELECT * FROM Posts AS a , Location AS b WHERE (a.Location_ID = b.Location_ID AND ((a.Description LIKE '%$search%') OR (a.Title LIKE '%$search%') OR (b.zipcode LIKE '%$search%') OR (b.LocationName LIKE '%$search%'))) ORDER BY a.TimeStamp DESC LIMIT $this_page_first_result, $results_per_page";
            $rs = $conn->query($sql);
            while ($row = $rs->fetch_assoc()) {
                echo "<div class='media'>";
                echo "<div class='media-left'>";
                if (isset($row['Image_1'])) {
                    echo "<img height='100' width='100' src='data:image;base64," . $row['Image_1'] . "'>";
                } elseif (isset($row['Image_2'])) {
                    echo "<img height='100' width='100' src='data:image;base64," . $row['Image_2'] . "'>";
                } elseif (isset($row['Image_3'])) {
                    echo "<img height='100' width='100' src='data:image;base64," . $row['Image_3'] . "'>";
                } else {
                    echo "<img height='100' width='100' src='no_img.png'";
                }
                echo "</div>";
                echo "<div class='media-body'>";
                echo "<h4 class='media-heading'>" . $row['Title'] . "</h4>";
                echo $row['Description'];
                $post_id = $row['Post_ID'];
                echo "<p><a href='postdetails.php?postid=$post_id' class='btn btn-primary' role='button'>View details &raquo;</a></p>";
                echo "</div>";
                echo "</div>";
                echo "<hr color='#eee'>";
            }
            echo "<div style='text-align: center;'>";
            for($page = 1 ; $page <= $number_of_pages ; $page++ ){
                echo"<a class = 'page' href='search_list.php?page=" . $page . "'>" . $page . "</a> ";
            }
            echo "</div>";
            $conn->close();
       ?>
    </div>
</body>
</html>