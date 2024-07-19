<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Client;
use OpenAI\Api\Endpoints\Engines;

class OpenAIController extends Controller
{
    public function index()
    {
        // Initialize the OpenAI client with your API key
        $client = new Client(env('OPENAI_API_KEY'));

        // Create an instance of Engines endpoint
        $engines = new Engines($client);

        // Example: Fetch available engines
        $response = $engines->list();

        // Handle the response
        dd($response);
    }
}
