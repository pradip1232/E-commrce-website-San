<?php 
// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Redirect to the homepage or dashboard if already logged in
    echo "<script>window.location='index'</script>";
}
?>