<?php
    include 'header.php'
?>

    <form action="/createEvent" method="POST" enctype="multipart/form-data">
        <input type="text" name="nameEvent" placeholder="Name Event">
        <br>
        <input type="date" name="startDate" placeholder="Start Date">
        <br>
        <input type="date" name="stopDate" placeholder="Stop Date">
        <br>
        <input type="number" name="amount" placeholder="amount">
        <br>
        <textarea name="description" placeholder="Description"></textarea>
        <br>
        <input type="file" name="picture[]" accept="image/*" multiple>
        <br>
        <input type="submit">
    </form>

<?php
    include 'footer.php'
?>