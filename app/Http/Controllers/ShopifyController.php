<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShopifyController extends Controller
{
    public function installShopify($shop = 'iflipmart')
    {
        $shopFull = "$shop.myshopify.com";
        $apiKey = env('SHOPIFY_API_KEY');
        $scopes = env('SHOPIFY_SCOPES');
        $redirectUri = env('APP_URL') . '/generate-token';
        $nonce = Str::random(12);

        // https://{shop}.myshopify.com/admin/oauth/authorize?client_id={client_id}&scope=unauthenticated_read_product_listings,unauthenticated_write_checkouts,unauthenticated_write_customers,unauthenticated_read_customer_tags,unauthenticated_read_content,unauthenticated_read_product_tags&redirect_uri=https://www.google.com/&state=nonce1

        $installUri = 
        "https://$shopFull/admin/oauth/authorize?client_id=$apiKey&scope=$scopes&redirect_uri=$redirectUri&state=$nonce";

        // https://www.google.com/&state=nonce1

        // var_dump($installUri); exit;
        return redirect($installUri);
    }

    public function generateToken(Request $request)
    {
        $apiKey = env('SHOPIFY_API_KEY');
        $secretKey = env('SHOPIFY_SECRET_KEY');

        $params = $_GET;
        $hmac = $request->get('hmac');

        $params = array_diff_key($params, array('hmac' => ''));
        ksort($params); // Sort params lexographically
        $computedHmac = hash_hmac('sha256', http_build_query($params), $secretKey);

        // Use hmac data to check that the response is from Shopify or not
        if (hash_equals($hmac, $computedHmac)) {
            // Set variables for our request
            $query = [
                "client_id" => $apiKey, // Your API key
                "client_secret" => $secretKey, // Your app credentials (secret key)
                "code" => $params['code'] // Grab the access key from the URL
            ];
            // Generate access token URL
            $accessTokenUrl = "https://" . $params['shop'] . "/admin/oauth/access_token";
            // Configure curl client and execute request
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_URL, $accessTokenUrl);
            curl_setopt($ch, CURLOPT_POST, count($query));
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
            $result = curl_exec($ch);
            curl_close($ch);
            // Store the access token
            $result = json_decode($result, true);
            $accessToken = $result['access_token'];
            // Show the access token (don't do this in production!)
            echo $accessToken;
        } else {
            // Someone is trying to be shady!
            die('This request is NOT from Shopify!');
        }
    }
}
