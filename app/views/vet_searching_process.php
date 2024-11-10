<?php
require_once 'db/db_connect.php';

if (isset($_GET['query'])) {
    // Get the search term entered by the user
    $searchTerm = htmlspecialchars($_GET['query']);

    // Your webpage content or the text you want to search within
    $webpageContent = "
    <h2>Welcome to Our Website</h2>
    <p>This is a demo page with various content. Feel free to explore and search for information.</p>
    <p>We offer services such as web development, design, and digital marketing.</p>
    <p>Contact us for more details on our services and pricing.</p>
    ";

    // Display the search results page header
    echo '<link rel="stylesheet" href="style.css">';
    echo '<h1>Search Results</h1>';
    echo '<div class="results">';

    // Check if the search term exists in the content
    if (stripos($webpageContent, $searchTerm) !== false) {
        echo "<p>Search term found!</p>";
    } else {
        echo "<p>No results found for '<strong>$searchTerm</strong>'</p>";
    }

    echo '</div>';
} else {
    echo "No search term provided.";
}
?>
