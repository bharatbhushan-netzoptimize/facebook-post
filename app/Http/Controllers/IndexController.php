<?php

namespace App\Http\Controllers;

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\FileUpload;

class IndexController extends Controller
{
    public function index()
    {

        return view("");
    }

    public function login()
    {

        // Initialize Facebook SDK 
        $fb = new Facebook([
          'app_id' => '6765931070182984',
          'app_secret' => '3d54bebdbdc2c9815118f33bf4bdf16b',
          'default_graph_version' => 'v2.10',
          ]);
        
        // Helper to get redirect login URL
        $helper = $fb->getRedirectLoginHelper(); 
        
        // Check if access token is available
        if(isset($_SESSION['facebook_access_token'])) {
        
          // User is already logged in
          $accessToken = $_SESSION['facebook_access_token'];
        
          // Post video
          postVideo($accessToken);
        
        } else {
        
          // User not logged in, show login URL  
          $loginUrl = $helper->getLoginUrl('http://facebook-share.test/', ['public_profile', 'user_videos']);
          
          echo '<a href="' . $loginUrl . '">Log in with Facebook</a>';
        
        }
        
        function postVideo($accessToken) {
        
          // Video file path
          $videoPath = 'uploads\ForBiggerEscapes.mp4'; 
        
          // Post video
          try {
              $response = $fb->post('/me/videos', [], $accessToken, ['source' => $videoPath]);
          } catch(Facebook\Exceptions\FacebookResponseException $e) {
              echo 'Error posting video: ' . $e->getMessage();
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
              echo 'FB SDK Error: ' . $e->getMessage();  
          }
        
        }

    }




    // public function shareVideo(Request $request)
    // {

    //     $myVideoFileToUpload = new FacebookVideo('uploads\ForBiggerEscapes.mp4');
    //     // Initialize the Facebook SDK
    //     $fb = new Facebook([
    //         'app_id' => '6765931070182984',
    //         'app_secret' => '3d54bebdbdc2c9815118f33bf4bdf16b',
    //         'default_graph_version' => 'v11.0',
    //     ]);
    //     // $helper = $fb->getRedirectLoginHelper();

    //     // $permissions = ['email']; // Optional permissions
    //     // $loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);

    //     // echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
    //     // dd($fb);
    //     // Set the user access token obtained through the login flow
    //     $accessToken = 'EABgJlBYDVkgBO271283o5VIPpxsKZCZAPPSwiQvZAkZCEtZB0dJNiWrcFqkFaH0hm9DPAAnqVHVtzFSy1g4O5LU83gCvfWqMbOB0VxmpZCN95wODQCwL5OtWu7zspMP9KUUUuGYjiz2S9Y5RGE5zUJ8ZB8NpwP0Thx5WZAZB2Vx3jrHMU5RhURMFOxoIZCspf9Mteo';

    //     // Video details
    //     // $videoPath = '"http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4"';
    //     $videoPath = 'uploads\ForBiggerEscapes.mp4"';
    //     // $title = 'My Awesome Video';
    //     // $description = 'More info about my awesome video.';

    //     $data = [
    //         'title' => 'My awesome video',
    //         'description' => 'More info about my awesome video.',
    //     ];

    //     try {
    //         // Upload video
    //         $response = $fb->uploadVideo('me', $videoPath, $data, $accessToken);

    //         // $response = $fb->videoToUpload($videoPath);w
    //         // dd();

    //         // Check if 'video_id' key exists in the response
    //         if (isset($response['video_id'])) {
    //             // Output the video ID
    //             echo 'Video ID: ' . $response['video_id'];
    //         } else {
    //             // Output the entire response for debugging
    //             echo 'Video upload failed. Response: ' . print_r($response, true);
    //         }
    //     } catch (FacebookResponseException $e) {
    //         echo 'Graph returned an error: ' . $e->getMessage();
    //     } catch (FacebookSDKException $e) {
    //         echo 'Facebook SDK returned an error: ' . $e->getMessage();
    //     }

    // }
}
