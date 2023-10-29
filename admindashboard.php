<?php
//include auth_session.php file on all user panel pages

include("authses.php");
include("connectdb.php");

$sql1 = "SELECT * FROM students";



if(isset($_POST["Clearbutton"])){
    unset($_SESSION["filter"]);
  }


if(isset($_POST['filter'])){
    $filter = $_POST['filter'];
    $sql1 .= " WHERE name LIKE '%{$filter}%' OR slot_booked LIKE '%{$filter}%'";
    $_SESSION['filter'] = $filter;

}else{
    if(isset($_SESSION['filter']) && strlen($_SESSION['filter'])>0 ){
      //reapply old filter if user is just sorting
      $filter = $_SESSION['filter'];
      $sql1 .= " WHERE name LIKE '%{$filter}%' OR slot_booked LIKE '%{$filter}%'";
    }
}

if(isset($_GET['sort'])){
    $sort = $_GET['sort'];
    $sql1 .= " ORDER BY $sort";
  }

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
        <li class="nav-item" style="float: left; font-family: geneva;"><a class="nav-link" href="admindashboard.php"><?php echo $_SESSION['username']; ?></a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
    </ul>

    <div class ="row">
        <h1>Welcome to Comp207!</h1>
    </div>

    <div class="tablec"> 
    <h2 style="text-align: center;">Student's Information</h2>

    <form class="filterform" method="post" action="admindashboard.php">
        <input type="text" id="filter" name="filter" placeholder="filter by name or slot" tabindex="0"/>
        <input type="submit" name="Filterbutton" id="Filterbutton" value="Go"/>
        <input type="submit" name="Clearbutton" id="Clearbutton" value="Clear Filter"/>
    </form>
    </br>
            
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

    <div class="tablec">
    <h2 style="text-align: center;">Practical Slots</h2>
            
    <table>
        <thead>
            <tr>
                <th>Day</th>
                <th>Time</th>
                <th>Seats Left</th>

            </tr>
        </thead>
            <tbody>
                <?php
                $sql2 = "SELECT * FROM slots";
                $result2 = mysqli_query($conn, $sql2);
                while ($row = $result2->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['day']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                    <td><?php echo $row['seats_left']; ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
    </table>
    </div>
    
</body>
</html>