<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home.main', [
            'status' => 'create'
        ]);
    }
    
    private function _generateRoom($userid) {
        $random_string = Str::random(6);
        $reservation_id = date('Y_m_d_His_'). $userid . '_' . $random_string;

        return $reservation_id;
    }

    private function sendMessage($recipients, $url)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);

        $message = "ナースホットラインからお知らせ⇒  " . $url;

        $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message] );
    }

    public function generateRoom(Request $request)
    {
        $userid = $request->input('userid');
        $reservation_id = $this->_generateRoom($userid);

        $url = $request->getHttpHost() . '/' . $reservation_id;
        
        $recipients = $userid;
        $this->sendMessage($recipient, $url);

        return view('home.main', [
            'status' => 'created',
            'reservation_id' => $reservation_id
        ]);
    }
}