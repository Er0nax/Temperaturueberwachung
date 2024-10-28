<?php

// token exists?
if (isset($_COOKIE['api_token'])) {
    setcookie('api_token', '', time() - 3600);
}

// redict to index
header('Location: index.php');