<?php
include("connectdb.php");
?>

<?php

$slot1 = "SELECT * FROM slots WHERE slotid ='1'";
$result = mysqli_query($conn, $slot1);
$row = $result->fetch_assoc();
$seat1 = $row['seats_left'];

$slot2 = "SELECT * FROM slots WHERE slotid ='2'";
$result2 = mysqli_query($conn, $slot2);
$row2 = $result2->fetch_assoc();
$seat2 = $row2['seats_left'];


$slot3 = "SELECT * FROM slots WHERE slotid ='3'";
$result3 = mysqli_query($conn, $slot3);
$row3 = $result3->fetch_assoc();
$seat3 = $row3['seats_left'];



$slot4 = "SELECT * FROM slots WHERE slotid ='4'";
$result4 = mysqli_query($conn, $slot4);
$row4 = $result4->fetch_assoc();
$seat4 = $row4['seats_left'];

function checkdupes($sid, $name, $email, $slot_booked){
    include("connectdb.php");
    $query = "SELECT * FROM students WHERE sid ='$sid'";
    $res = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($res) > 0){
        $row = $res->fetch_assoc();
        $name1 = $row['name'];
        $email1 = $row['email'];
        $slot_booked1 = $row['slot_booked'];
        if ($name1 == $name && $email1 == $email && $slot_booked1 != $slot_booked){
            ?> <script> 
            alert("Hello id number " + <?php echo $sid ?> + "! Changing your slot from " + <?php echo $slot_booked1 ?> + " to " + <?php echo $slot_booked ?> +"!") </script>
                <?php
                $query2 = "UPDATE students SET slot_booked = '$slot_booked' WHERE sid = '$sid'";
                $res2 = mysqli_query($conn, $query2);
                $query3 = "UPDATE slots SET seats_left = seats_left - 1 WHERE slotid = '$slot_booked'";
                $res3 = mysqli_query($conn, $query3); 
                $query4 = "UPDATE slots SET seats_left = seats_left + 1 WHERE slotid = '$slot_booked1'";
                $res4 = mysqli_query($conn, $query4);
                header("Refresh:0");           

            return True;
        }

        else if ($name1 == $name && $email1 == $email && $slot_booked1 == $slot_booked) {
            ?> <script> alert("Your information has already been recorded")  </script>
            <?php
        }
        else {
            ?> <script> alert("Please enter your correct sid")  </script>
            <?php
            return True; 
            }
    } else {
        return False;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <ul class="navbar">
        <li class="nav-item" style="float: left; font-family: geneva;"><a class="nav-link" href="#">COMP207</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Admin login</a></li>
    </ul>

    <div class ="row">
        <h1>Welcome to Comp207!<br>Register here for a practical slot</h1>
    </div>

    <div class = "infobox">
        <div class = "info">
            <p><b>Register only if you know what you are doing</b></p>
            <ul>
                <li>Please enter all your information and select your desired day</li>
                <li>Please enter a correct SID number</li>
                <li>Please check the number of available seatsbefore submitting</li>
                <li>Register only to one slot</li>
                <li>Any problems? Write a message to <a style="color: blue" href = "#">bracu@gmail.com</a></li>
                <li><span style="color: red">If you want to change your slot: </span> Simply enter all your previous information correctly with the the slot changed</li>
            </ul>
        </div>

        <div class="bookinginfo">
            <form class="bookingform" method = "post">
                <label for="bookingform-input">Name</label>
                <input type="text" class="bookingform-input" name="name" placeholder="name" autofocus="true" required/>

                <label for="bookingform-input">SID</label>
                <input type="text" class="bookingform-input" name="sid" placeholder="sid" autofocus="true" required/>

                <label for="bookingform-input">Email</label>
                <input type="email" class="bookingform-input" name="email" placeholder="email" autofocus="true" required/>
                
                </br>

                <p><b>Select the practical slot</b></p>

                <select class="bookingform-input" name="slot_booked" onclick = "checkseats()"required>
                    <option value="Monday 15:00-17:00" id="seat1">Monday 15:00-17:00 &emsp; <?php echo $seat1 ?> seats
                        remaining
                    </option>
                    <option value="Tuesday 14:00-16:00" id="seat2">Tuesday 14:00-16:00 &emsp; <?php echo $seat2 ?> seats
                        remaining
                    </option>
                    <option value="Thursday 11:00-13:00" id="seat3">Thursday 11:00-13:00 &emsp; <?php echo $seat3 ?> seats
                        remaining
                    </option>
                    <option value="Friday 10:00-12:00" id="seat4">Friday 10:00-12:00 &emsp; <?php echo $seat4 ?> seats
                        remaining
                    </option>

                </select>

                <div class = "bookingform-btn">
                <input type="submit" value="Register" name="register"/>
                
                <input type="submit" value="Clear" name="clear" onclick="clearit()"/></div>
            </form>
        </div>
    </div>

    <?php
        if(isset($_POST['register']))
        {
            $name = stripslashes($_POST['name']);
            $email = stripslashes($_POST['email']);
            $sid = stripslashes($_POST['sid']);

            $booked = False;
            if ($_POST['slot_booked'] == "Monday 15:00-17:00")
            {
                if ($seat1 == 0){
                    ?><script> alert("No more seats can be booked in this slot") </script><?php }                
                else {
                    $slot_booked = 1;
                    $booked = True;
                    }
            }
            elseif ($_POST['slot_booked'] == "Tuesday 14:00-16:00")
            {
                
                if ($seat2 == 0){
                    ?><script> alert("No more seats can be booked in this slot") </script><?php }
                else{
                    $slot_booked = 2;
                    $booked = True;
                }
            }
            elseif ($_POST['slot_booked'] == "Thursday 11:00-13:00")
            {
                
                if ($seat3 == 0){
                    ?><script> alert("No more seats can be booked in this slot") </script><?php }
                else {
                    $slot_booked = 3;
                    $booked = True;
                }
            }
            elseif ($_POST['slot_booked'] == "Friday 10:00-12:00")
            {
                
                if ($seat4 == 0){
                    ?><script> alert("No more seats can be booked in this slot") </script><?php }
                else {
                    $slot_booked = 4;
                    $booked = True;
                }
            }

            if ($booked == True) {
                // Create SQL query for adding customer
                if (checkdupes($sid, $name, $email, $slot_booked) == False) {
                $sql1 = "INSERT INTO students (name, email, sid, slot_booked) 
                        VALUES ('$name', '$email', '$sid', '$slot_booked')";

                // Execute the query
                $res1 = mysqli_query($conn, $sql1);
                
                if($res1)
                {   
                    $sql2 = "UPDATE slots SET seats_left = seats_left - 1 WHERE slotid = '$slot_booked'";
                    $res2 = mysqli_query($conn, $sql2);
                    echo "Slot booked successfully!";
                    header("Refresh:0");
                    
                }
                else
                {  
                    ?><script> alert("error") </script><?php
                }


            }
        }
   
        }


        ?>

<script> 
function clearit() {
    document.getElementById("bookingform-input").value='';
}

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
    }

function checkseats() {
    if (<?php echo $seat1 ?> == 0){
        document.getElementById('seat1').disabled = true;
    }
    if (<?php echo $seat2 ?> == 0){
        document.getElementById('seat2').disabled = true;
    }
    if (<?php echo $seat3 ?> == 0){
        document.getElementById('seat3').disabled = true;
    }
    if (<?php echo $seat4 ?> == 0){
        document.getElementById('seat4').disabled = true;
    }
}



</script>
    
</body>
</html>