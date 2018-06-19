<?php
    include_once 'header.php'
        
?>
	<section class="main-container">
        <div class="main-wrapper">
            <h2>Home</h2> 
            <?php
                                        
                if (isset($_SESSION['u_id'])) {
                    echo "Friend List:";
                    }
                  /* vil gerne have linket min dbh.inc.php */  
                    $dbServername = 'localhost';
                    $dbUsername = 'root';
                    $dbPassword = '1234';
                    $dbName = 'crud';

                    $conn = mysqli_connect('localhost', 'root', '1234', 'crud');

        $result = mysqli_query($conn,"SELECT * FROM users");
        if (isset($_SESSION['u_id'])) {
        echo "<table border='1'>
        <tr>
        <th>Firstname:</th>
        <th>Lastname:</th>
        <th>Email:</th>
        </tr>";

            while($row = mysqli_fetch_array($result))
            {
                echo "<tr>";
                echo "<td>" . $row['user_first'] . "</td>";
                echo "<td>" . $row['user_last'] . "</td>";
                echo "<td>" . $row['user_email'] . "</td>";
                echo "</tr>";
            }
                echo "</table>";
}


             ?>
        </div>	

	</section>
<?php
    include_once 'footer.php'
?>


