<?php // upload.php
// Replace with your Bunny Stream credentials
$libraryId = '400041';
$apiKey = 'a2b1e58c-f85c-4f05-801e72509d66-ebd0-433f';

// Check if a file was uploaded
if (isset($_FILES['videoFile']) && $_FILES['videoFile']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['videoFile']['tmp_name'];
    $fileName = $_FILES['videoFile']['name'];
    
    // Step 1: Create a video object in Bunny Stream
    $createVideoUrl = "https://video.bunnycdn.com/library/$libraryId/videos";
    $postData = json_encode(['title' => $fileName]);
    
    $ch = curl_init($createVideoUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "AccessKey: $apiKey"
    ]);
    
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo "Error creating video: " . curl_error($ch);
        exit;
    }
    $result = json_decode($response, true);
    curl_close($ch);
    
    if (!isset($result['guid'])) {
        echo "Failed to create video object.";
        echo "<pre>".print_r($result, true)."</pre>";
        exit;
    }
    
    $videoGuid = $result['guid'];
    
    // Step 2: Upload the video file to the created video object
    $uploadUrl = "https://video.bunnycdn.com/library/$libraryId/videos/$videoGuid";
    $videoData = file_get_contents($fileTmpPath);
    
    $ch = curl_init($uploadUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $videoData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/octet-stream",
        "AccessKey: $apiKey"
    ]);
    
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo "Error uploading video: " . curl_error($ch);
        exit;
    }
    curl_close($ch);

    // Get video status to check if it's ready
    $statusUrl = "https://video.bunnycdn.com/library/$libraryId/videos/$videoGuid";
    $ch = curl_init($statusUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Accept: application/json",
        "AccessKey: $apiKey"
    ]);
    
    $response = curl_exec($ch);
    $videoInfo = json_decode($response, true);
    curl_close($ch);
    
    // Display the uploaded video
    // Correctly formatted embed URL for Bunny Stream
    $videoUrl = "https://iframe.mediadelivery.net/embed/$libraryId/$videoGuid?autoplay=false";
    $hlsUrl = "";

    if (isset($videoInfo['hls']) && isset($videoInfo['hls']['url'])) {
        $hlsUrl = $videoInfo['hls']['url'];
    } else if (isset($videoInfo['hlsUrl'])) {
        // Alternative property name in case API returns it differently
        $hlsUrl = $videoInfo['hlsUrl'];
    }
    
    echo "<h2>Video Uploaded Successfully!</h2>";
    echo "<p>Video status: " . ($videoInfo['status'] ?? 'Unknown') . "</p>";
    echo "<p>It may take a few minutes for the video to process before it's viewable.</p>";
    echo "<iframe src='$videoUrl' width='640' height='360' frameborder='0' allowfullscreen></iframe>";
    
    // Debugging info
    echo "<div style='margin-top: 20px; padding: 10px; background-color: #f5f5f5;'>";
    echo "<h3>Debug Information:</h3>";
    echo "<p>Video GUID: $videoGuid</p>";
    echo "<p>Embed URL: $videoUrl</p>";
    echo "</div>";

    echo "<br><br>";
    echo "formated hls url: " . "https://vz-bb9f9f00-79f.b-cdn.net/$videoGuid/playlist.m3u8";
    echo "<br><br>";


    echo "HLS link : $hlsUrl" . "<br><br>";
    echo  json_encode($result);
} else {
    echo "No file uploaded or an upload error occurred.";
    if (isset($_FILES['videoFile'])) {
        echo "<p>Error code: " . $_FILES['videoFile']['error'] . "</p>";
    }
}



?>



<!-- https://vz-bb9f9f00-79f.b-cdn.net/c7d4dad3-4641-42ce-95d9-19ee03d84e30/playlist.m3u8 -->
<!-- https://vz-bb9f9f00-79f.b-cdn.net/c7d4dad3-4641-42ce-95d9-19ee03d84e30/playlist.m3u8 -->