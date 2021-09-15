<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reservation;
use App\Models\VideoChatManager;
use Illuminate\Support\Str;

class VideoChatController extends Controller
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

    public function index($reservation_id)
    {
        return view('videochat', [
            'reservation_id' => $reservation_id,
            'type' => 'create'
        ]);
    }

    /**
     * Process to create room.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function generateRoom(Request $request)
    {
        $userid = $request->input('userid');
        $random_string = Str::random(6);
        $reservation_id = date('Y_m_d_His_') . $random_string;
        return view('room.main', [
            'reservation_id' => $reservation_id
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create($reservation_id)
    {
        return view('videochat', [
            'reservation_id' => $reservation_id,
            'type' => 'create'
        ]);
    }

    public function joinRoom($reservation_id)
    {
        return view('room.chat', [
            'reservation_id' => $reservation_id,
            'type' => 'join'
        ]);
    }

    public function authentication(Request $request)
    {
        $ret = ["error_message"=>"", "error_code"=>0];

        $params = $request->all();

        if (empty($params["reservation_id"]) || empty($params["type"])) {
            $ret["error_code"] = 1;
            return response()->json($ret);
        }

        $recordReservation = Reservation::find($params["reservation_id"]);

        if (empty($recordReservation)) {
            $ret["error_code"] = 2;
            return response()->json($ret);
        }

        $pear_id = '';
        $remote_pear_id = '';
        if ($params['type'] == 'create'){
            $pear_id = $recordReservation['pear_id_a'];
            $remote_pear_id = $recordReservation['pear_id_b'];
            
        } else {
            $pear_id = $recordReservation['pear_id_b'];
            $remote_pear_id = $recordReservation['pear_id_a'];
        }


        $duration = VIDEOCHAT_EXPIRED_DURATION;

        if ($duration < 600)
            $duration = 600;

        $apiKey = config('app.skyway_app_key');
        $apiSec = config('app.skyway_app_sec');

        $authInfo = VideoChatManager::authentication($apiKey, $apiSec, $pear_id, $duration);

        if (!is_array($authInfo)) {
            $ret["error_code"] = 5;
            return response()->json($ret);
        }

        $authInfo["remotePeerId"] = $remote_pear_id;
        $authInfo["apiKey"] = $apiKey;

        $ret["auth_info"] = $authInfo;

        return response()->json($ret);
    }

}
