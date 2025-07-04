<?php
namespace App\Http\Controllers\Postman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;

class PostmanTestController extends Controller
{
    public function run(Request $request)
    {

        $url    = $request->input('url');
        // $method = strtoupper($request->input('method'));
        // $token  = $request->input('token');
        $body   = json_decode($request->input('body'), true);

        // // // dd($url, $method, $token, $body);

        // $test_response = Http::timeout(30)
        //     ->withToken($token)
        //     ->send($method, $url, ['json' => $body]);

        // // return back()->with('test_response', $response->body());

        // // $test_response = Http::timeout(15)->get('https://jsonplaceholder.typicode.com/posts/1');
        // // $test_response = Http::timeout(60)->post('http://127.0.0.1:8000/api/auth/login');


        // dd($test_response->json());




$client = new Client([
    'timeout' => 30,
]);

$response = $client->post($url, [
    'headers' => [
        // 'Authorization' => 'Bearer ' . $token,
        'Accept'        => 'application/json',
    ],
    'json' => $body,
]);

$data = json_decode($response->getBody(), true);
dd($data);


    }
}
