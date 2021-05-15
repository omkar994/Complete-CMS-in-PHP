<html>
    <head>
        <title>test function call</title>
    </head>
    <body>
    <!DOCTYPE html>
<html>
<body>

<?php
    //check if the get variable exists
    if (isset($_GET['search']))
    {
        search($_GET['search']);
    }

    function search($res)
    {
        //real search code goes here
        echo $res;
    }


?>

<a href="?search=15">Search</a>

</body>
</html>
    </body>
</html>