<?php
//include auth_session.php file on all user panel pages
include("authses.php");
include("connectdb.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <ul class="navbar">
    <ul class="navbar">
        <li class="nav-item" style="float: left; font-family: geneva;"><a class="nav-link" href="admindashboard.php"><?php echo $_SESSION['username']; ?></a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        <li class="nav-item"><a class="nav-link" href="adminview-slot4.php">Slot 4</a></li>
        <li class="nav-item"><a class="nav-link" href="adminview-slot3.php">Slot 3</a></li>
        <li class="nav-item"><a class="nav-link" href="adminview-slot2.php">Slot 2</a></li>
        <li class="nav-item"><a class="nav-link active" href="adminview-slot1.php">Slot 1</a></li>
    </ul>
    </ul>

    <div class ="row">
        <h1>Welcome to Comp207!</h1>
    </div>

    <div class="tablec"> 
    <h2 style="text-align: center;">Student's Information</h2>
            
    <table>
        <thead>
            <tr>
                <th><a href="admindashboard.php?sort=name">Name</a></th>
                <th><a href="admindashboard.php?sort=sid">Student Id</a></th>
                <th><a href="admindashboard.php?sort=email">Email</a></th>
                <th><a href="admindashboard.php?sort=slot_booked">Slot Booked</a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql1 = "SELECT * FROM students";
            if(isset($_GET['sort'])){
                $sort = $_GET['sort'];
                $sql1 .= " ORDER BY $sort";
              }
            $result1 = mysqli_query($conn, $sql1);
            while ($row = $result1->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['sid']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['slot_booked']; ?></td>

            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    </div>
    
</body>
</html>