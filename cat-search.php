<!DOCTYPE html>
<html>

<script src="js/jquery.js"></script>

<script>
    $(document).ready(function(){
        $('#cat_form').submit(function(event) {
            event.preventDefault();
            $catForm = this;
            alert('hi');
            $.ajax({ // create an AJAX call...
                data: $catForm.serialize(), // get the form data
                type: $catForm.attr('method'), // GET or POST
                url: './get-events-by-category.php', // the file to call
                success: function(response) { // on success..
                    var temp = JSON.parse(response);
                    if (temp[0] === 'success') {
                        var results = JSON.parse(temp[1]);
                        for (var i = 0; i < results.length; i++) {
                            var ename = results[i]['ename'];
                            var desc = results[i]['description'];
                            $('#event_results').append("<li>"+ename+": " +desc+"</li>"); // update the DIV
                        }
                        alert('success');
                    } else {
                        alert("failure");
                    }
                }
            });
            return false; // cancel original event to prevent form submitting
        )};
    )};
</script>


<body>

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

<form id="cat_form" method="POST">
    Enter name: <input type="text" name="category">
    <input type="submit" value="Submit">
</form>

<p>Results:</p>
<ul id="event_results">
</ul>

</body>
</html>
