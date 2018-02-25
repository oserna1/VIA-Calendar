<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    function myFunc() {
        $("#myForm").submit(function(e){
            e.preventDefault();
        });

        var request = $.ajax({
            type: "POST",
            url: "./hello_back.php",
            data: $('#myForm').serialize()
        });

        request.done(function(response) {
            var results = JSON.parse(response);
            //alert ( results.length);
            $('#event_results').empty();
            for (var i = 0; i < results.length; i++) {
                var ename = results[i]['ename'];
                var desc = results[i]['description'];
                $('#event_results').append("<li>"+ename+": " +desc+"</li>");
                //$('#event_results').append('<li>hello</li>');
                //$("#content").append('<li>qwerty</li>');
            }
        });

        request.fail(function(jqXHR, textStatus) {
            alert( "Request failed: " + textStatus );
        });
    }
</script>


<p>Search for events tagged with the specified category</p>

These are all the categories currently in the database:
<?php
include('database.php');
$conn = connect_db();
$result = mysqli_query($conn, "SELECT DISTINCT tags FROM Events ORDER BY tags DESC");
echo "<ul id='current_cats'>";
while($row = mysqli_fetch_assoc($result)) {
    echo "<li>{$row['tags']}</li>";
}
echo "</ul>";
?>


<form id="myForm" method="POST">
    Enter category: <input type="text" name="category">
    <input type="submit" value="Submit" onclick="myFunc()">
</form>

<p>Results:</p>
<ul id="event_results"></ul>
