<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Stevebauman\Location\Facades\Location;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $ip = \Request::ip();/* Static IP address */
        $currentUserInfo = Location::get($ip);
        return view('user', compact('currentUserInfo'));
    }


    public function location_send(Request $request)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&key=AIzaSyDeok1B6-vqMOXAQuEUbo58Ivc7HY-IcN8', true);
        $output = json_decode($geocodeFromLatLong);
        $status = $output->status;
        $address = ($status == "OK") ? $output->results[1]->formatted_address : '';
        if (!empty($address)) {
            $to = 'mamtakkr007@gmail.com';
            $to_name = 'Gs Webtech';
            $from = env('MAIL_USERNAME');
            $from_name = env('MAIL_FROM_NAME');
            $body = "Your current location is: <br>" . $output->results[1]->formatted_address . ". <br>";
        
            app('App\Http\Controllers\EmailController')->send_email($to, $to_name, $from, $from_name, 'Email', [
                'greeting' => "<b>Hi user,</b><br>",
                'title' => "<b>Email For Current Location:</b><br>",
                'body' => $body,
                'footer' => "<b>From: </b>Support team"
            ]);

            return json_encode($address);
        } else {
            return false;
        }
    }
}
