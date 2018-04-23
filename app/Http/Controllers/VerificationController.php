<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\KycVerification;

class VerificationController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show Portfolio Page
     *
     * @return \Illuminate\Http\Response
    */
    public function index() {
        return view('verification.index');
    }

    /**
     * Verify User ID
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request) {
        $this->validate($request, [
            'method' => 'required|in:id_card,passport,driving_license'
        ]);

        $user = Auth::user();
        $reference = date('Ym') . substr(hexdec(uniqid()), 0, 8);
        $post_data = array(
            "method" => $request->input('method'),
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "dob" => $user->dob, //Customer date of birth in valid date format
            "reference" => $reference,
            "country" => $user->country,
            "phone_number" => $user->phone,
            "callback_url" => route('verification.callback'),
            "redirect_url" => route('verification.result')
        );

        $response = $this->callAPI($post_data);

        if (!empty($response) && $response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if ($result->status_code == 'SP2') {

                KycVerification::create([
                    'user_id' => $user->id,
                    'reference' => $reference,
                    'status' => 0
                ]);

                return redirect()->away($result->message);

                // dd($result);

                // return view('verification.verify', ['verification_link' => $result->message]);
            } else {
                $message = $result->message;
            }
        } else {
            $message = "Opps, Verification Service temporarly unavailable. Please try again later.";
        }

        $data['heading'] = 'Sorry';
        $data['message'] = $message;
        $data['description'] = 'Please email me support@huntercorprecords.com if you have any inquires.';
        $data['link_label'] = 'Back';
        $data['link'] = route('verification.index');

        return view('layouts.error', $data);
    }

    public function callback($request) {
        return 'success';
    }

    /**
     * Handle redirect from Shufti Pro Verification service
     * Sample Post Data
     * status_code "SP0"
     * message "Not Verified"
     * reference "20180415984947"
     * signature "02da8ea3df468cc84bd3cacf3db07d13d543d5b772451ae09f93bbf023e97f3f"
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function result(Request $request) {
        $reference = $request->input('reference');
        $verification = KycVerification::where('reference', $reference)->first();
        if (!empty($verification)) {
            $user = $verification->user;
            if ($request->input('status_code') == 'SP2') {
                $verification->status = 1;
                $verification->save();

                $user->kyc_verified = true;
                $user->save();

                addToWhitelist($user->wallet[0]->address);

                $data['heading'] = 'Successfully Verified';
                $data['message'] = 'Now you can participate Hunter Corp Records ICO';
                $data['description'] = 'Please email me support@huntercorprecords.com if you have any inquires.';
                $data['link_label'] = 'Go to Dashboard';
                $data['link'] = route('users.dashboard');
            } else {
                $data['heading'] = 'Not Verified';
                $data['message'] = 'Failed to verify your ID. Please try again with valid document.';
                $data['description'] = 'Please email me support@huntercorprecords.com if you have any inquires.';
                $data['link_label'] = 'Back';
                $data['link'] = route('verification.index');
            }
            return view('layouts.error', $data);
        }
        return abort(404);
    }

    private function callAPI($post_data, $url = '') {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.shuftipro.com/',
            // You can set any number of default request options.
            'timeout'  => 10.0
        ]);
        $post_data['client_id'] = env('SHUFTI_CLIENT_ID');
        ksort($post_data);//Sort the all request parameter.
        $raw_data = implode('', $post_data) . env('SHUFTI_SECRET_KEY');
        $signature = hash('sha256', $raw_data);
        $post_data['signature'] = $signature;

        try {
            $response = $client->request('POST', '/'.$url, [
                'form_params' => $post_data
            ]);
            return $response;
        } catch(\Exception $ex) {
            $message = $ex->message;
        }

        return null;
    }
}
