<?php 

    $con = mysqli_connect('localhost','id19955327_lovejoy','Mansahej3009!','id19955327_lovejoydb');
    
    // Function Clean String Values
    function escape($string)
    {
        global $con;
        return mysqli_real_escape_string($con,$string);
    }

    // Query Function
    function Query($query)
    {
        global $con;
        return mysqli_query($con,$query);
    }

    // Confirmation Function
    function confirm($result)
    {
        global $con;
        if(!$result)
        {
            die('Query Failed'.mysqli_error($con));
        }
    }

    // Fetching Data From Database
    function fetch_data($result)
    {
        return mysqli_fetch_assoc($result);
    }

    // Row Values From Database
    function row_count($count)
    {
        return mysqli_num_rows($count);
    }

?>