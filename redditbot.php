<?php
// Function to get an access token from Reddit with detailed debugging
function getAccessToken($client_id, $client_secret, $username, $password) {
    $token_url = "https://www.reddit.com/api/v1/access_token";

    $headers = [
        'Authorization: Basic ' . base64_encode("$client_id:$client_secret"),
        'Content-Type: application/x-www-form-urlencoded'
    ];

    $post_fields = http_build_query([
        'grant_type' => 'password',
        'username' => $username,
        'password' => $password
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request
    $response = curl_exec($ch);

    // Check if there was an error during the curl request
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        curl_close($ch);
        return null;
    }

    curl_close($ch);

    // Decode the response to understand what Reddit is sending back
    $response_data = json_decode($response, true);

    // Debug: Print the entire response from Reddit
    echo "<pre>";
    print_r($response_data);
    echo "</pre>";

    // Check if an access token was returned
    if (isset($response_data['access_token'])) {
        return $response_data['access_token'];
    } else {
        // If no access token, check for error messages
        echo "Error obtaining access token: ";
        if (isset($response_data['error'])) {
            echo $response_data['error'];
        } else {
            echo "Unknown error.";
        }
        return null;
    }
}

// Function to fetch new posts from a subreddit
function getSubredditPosts($access_token, $subreddit) {
    $url = "https://oauth.reddit.com/r/$subreddit/new";

    $headers = [
        "Authorization: Bearer $access_token",
        'User-Agent: your_bot/0.1 by your_reddit_username'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Function to reply to a Reddit post
function replyToPost($access_token, $post_id, $comment) {
    $url = "https://oauth.reddit.com/api/comment";

    $headers = [
        "Authorization: Bearer $access_token",
        'User-Agent: your_bot/0.1 by your_reddit_username'
    ];

    $post_fields = http_build_query([
        'thing_id' => $post_id,
        'text' => $comment
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Function to save processed post IDs in a file
function saveProcessedPost($post_id) {
    file_put_contents('processed_posts.txt', $post_id . PHP_EOL, FILE_APPEND);
}

// Function to check if a post has already been processed
function isPostProcessed($post_id) {
    if (!file_exists('processed_posts.txt')) {
        return false;
    }

    $processed_posts = file('processed_posts.txt', FILE_IGNORE_NEW_LINES);
    return in_array($post_id, $processed_posts);
}

// Your Reddit app credentials
$client_id = 'v-IF0SW7BXPDAZroAKj5_Q';   // Replace with your client_id
$client_secret = '8a3aXRDLbt7AYDg_yvLC64f-zYXA1w'; // Replace with your client_secret
$username = 'easyaceDOTai';   // Replace with your Reddit bot username
$password = 'She-wolf11';   // Replace with your Reddit bot password

// Get an access token
$access_token = getAccessToken($client_id, $client_secret, $username, $password);
echo "Access Token: " . $access_token . "<br>";


// List of subreddits to scan
$subreddits = ['CROSSOVERforWORK', 'HomeworkHelp']; // Replace with actual subreddit names

// Keyword to look for in post titles
$keyword = 'Crossover';  // Replace with the keyword you want to search for in the post titles

// Loop through each subreddit
foreach ($subreddits as $subreddit) {
    $posts = getSubredditPosts($access_token, $subreddit);

    // Process each post
    foreach ($posts['data']['children'] as $post) {
        $post_title = strtolower($post['data']['title']);
        $post_id = $post['data']['name']; // Use 'name' for the post ID

        // Check if the post contains the keyword and hasn't been processed yet
        if (strpos($post_title, $keyword) !== false && !isPostProcessed($post_id)) {
            // Reply to the post
            replyToPost($access_token, $post_id, "This is an automated reply.");

            // Save the post ID to avoid duplicate replies
            saveProcessedPost($post_id);
        }
    }
}
?>
