<?php
date_default_timezone_set('Europe/London');
// ID of the Blog Site to Post to. The ID below is for our test site.
$blogID = '1585389368411189747';
// Token you will need to authenticate with . It will come from the oAuth.
$authToken = '';
// Currently hard coded. This needs to come from the new form. The Time is fixed to 08:00:00 time.
$start_date = '2020-06-07T08:00:00.108Z';   
// Currently hard coded. This needs to come from the new form 
$article_count = 7; 
// Loop through and create the articles
for ($x = 0;$x <= $article_count;$x++)
{
    // The data to send to the API
    $postData = array(
        'kind' => 'blogger#post',
        'blog' => array(
            'id' => $blogID
        ) ,
        'title' => 'This is the Post Title - ' . date('jS F Y', strtotime($start_date)) ,
        "labels" => ["Daily Discussion"],
        "published" => date('Y-m-d\TH:i:sP', strtotime($start_date)) ,
        'content' => 'Content of the Article goes here'
    );
    $start_date = date('Y-m-d H:i:s', strtotime($start_date . ' +1 day'));
    // Setup cURL
    $ch = curl_init('https://www.googleapis.com/blogger/v3/blogs/' . $blogID . '/posts/');
    curl_setopt_array($ch, array(
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $authToken,
            'Content-Type: application/json'
        ) ,
        CURLOPT_POSTFIELDS => json_encode($postData)
    ));
    // Send the request
    $response = curl_exec($ch);
    // Check for errors
    if ($response === false)
    {
        die(curl_error($ch));
    }
    echo ($response);
    // Decode the response
    $responseData = json_decode($response, true);
    // Print the date from the response
    echo $responseData['published'];
}
?>
