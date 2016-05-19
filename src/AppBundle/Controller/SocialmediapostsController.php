<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Facebook;
namespace AppBundle\Controller;
use Facebook;
use Facebook\Authentication\AccessToken;
use TwitterAPIExchange;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SocialmediapostsController extends Controller
{
    /**
     * @Route("/app/addtwitterpost/", name="twitterpost")
     */
    
    public function addtwitterpostAction(Request $request)
    {
        
    $settings = array(
    'oauth_access_token' => "4859562552-w0pFTP4R3aQhCmhlrgFa6AKMnPk2WSixSlNjrdT",
    'oauth_access_token_secret' => "TBzagZBwOdrUeguiZAsssIt4VsCKgBNYbqwNmfdBck1I6",
    'consumer_key' => "zl37Ga0U0fzTWnuRxAAedywRr",
    'consumer_secret' => "FMy9gydLJrOYDrRnYNmxEfno6UG1kRev6lMRCjPCs6aLPOSEQo"
);
    
    $url = 'https://api.twitter.com/1.1/statuses/update.json';
$requestMethod = 'POST';

$postfields = array(
    'status' => 'First Tweet using API !! '
);

$twitter = new TwitterAPIExchange($settings);
echo $twitter->buildOauth($url, $requestMethod)
    ->setPostfields($postfields)
    ->performRequest();
    
    }
    
    /**
     * @Route("/app/facebooklogin/", name="facebooklogin")
     */
    
    public function facebookloginAction(Request $request)
    {
        $app_id = '199499140130486';
        $app_secret = '98cc2a03538a1fedd4d86b0671e944e5';
         $fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.2',
  ]);

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'user_posts'];
        $callback = 'http://localhost:8000/app/addfacebookpost/';
        // https://www.facebook.com/v2.2/dialog/oauth?client_id=199499140130486&state=445efbd510754cc7526c46cfceb8d1a8&response_type=code&sdk=php-sdk-5.1.2&redirect_uri=http%3A%2F%2Flocalhost%3A8000%2Fapp%2Faddfacebookpost%2F&scope=email%2Cuser_posts
        // https://www.facebook.com/v2.2/dialog/oauth?client_id=199499140130486&state=53f4b084eb88c5b879a0f6c0b672d108&response_type=code&sdk=php-sdk-5.1.2&redirect_uri=http%3A%2F%2Flocalhost%3A8000%2Fapp%2Faddfacebookpost%2F&scope=email%2Cuser_posts
        $loginUrl = $helper->getLoginUrl($callback, $permissions);
        echo '<a href="'.$loginUrl.'">Facebook Access</a>';
    }
    
    /**
     * @Route("/app/addfacebookpost/", name="facebookpost")
     */
    
    public function addfacebookpostAction(Request $request)
    {
        $app_id = '199499140130486';
        $app_secret = '98cc2a03538a1fedd4d86b0671e944e5';
      //  $access_token = 'CAAC1cYNhZArYBADnWBf62wXV6tZCiZCbYybIhR9cqerYG5tkOXZC3ywryWDz37N2WgLyE5VcSZBTe6Ygc5cOaQg095D8xJ9hnITPGAr0DOv6XV2D2XOQYNulacPPmQhyZCZC7A2bYiMoQSuoz5X6rJZCnSgtZBm04ZAx9u5h9pAUA3lCYINLLpZBgvy8tiV9PZA6UjpLcr6YqLrDyAZDZD';
        //$appsecret_proof= hash_hmac('sha256', $access_token, $app_secret);
        
        
        $fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.2',
  ]);

        $helper = $fb->getRedirectLoginHelper();
        try{
            echo 'Trying to obtain an access token !! ';
        $access_token = $helper->getAccessToken();
        echo 'Token variable: '.$access_token;
        }
 catch (Facebook\Exceptions\FacebookResponseException $e)
 {
     // When Graph returns an error
  echo 'Graph returned an error when getting access token: ' . $e->getMessage();
  exit;
     
 }
 catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error when getting access token: ' . $e->getMessage();
  exit;
}


if (isset($access_token)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $access_token;
echo 'Token Value set !! ';
  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
} elseif ($helper->getError()) {
  // The user denied the request
    echo 'Token NA :( !! ';
  exit;
}
$linkData = [
  'link' => 'http://www.thisisit.com',
  'message' => 'second Post',
  ];

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->post('/me/feed', $linkData, $access_token);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$graphNode = $response->getGraphNode();

echo 'Posted with id: ' . $graphNode['id'];

    }
    
 /**
     * @Route("/app/graphapifacebookpost/", name="graphapifacebookpost")
     */
    
    public function graphapifacebookpostAction(Request $request)
    {   
        
        $app_id = '199499140130486';
        $app_secret = '98cc2a03538a1fedd4d86b0671e944e5';
     
        
        
        $fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.2',
  ]);

        $access_token = new Facebook\Authentication\AccessToken($app_id,$app_secret);
        var_dump($access_token);
        echo 'Access Token: '.$access_token;
        return $access_token;
         
    }
    
}

