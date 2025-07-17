<?php
include 'db.php';

if ($conn) {
    echo "✅ Connected to the database successfully!";
} else {
    echo "❌ Connection failed.";
}
?>
