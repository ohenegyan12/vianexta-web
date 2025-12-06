<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class ManualLoginController extends Controller
{
  public function triggerLogin(Request $request)
  {
    session()->forget('registration_successful');
    $this->validate($request, [
      'email' => 'required|string|email|max:255|',
      'password' => 'required'
    ]);

    $helper = new Helper();

    $payload = array("email" => $request->email, "password" => $request->password);
    $attemptLogin = $helper->hitCoffeePlugEndpoint($payload, "login");
    // dd($attemptLogin, $payload);
    if (!isset($attemptLogin->statusCode)) {
      error_log('ManualLoginController: Login failed - no status code, setting error: Login authentication failed');
      return redirect()->back()->with('error', "Login authentication failed")->withInput();
    }

    if ($attemptLogin->statusCode != 200) {
      error_log('ManualLoginController: Login failed - status code: ' . $attemptLogin->statusCode . ', message: ' . $attemptLogin->message);
      return redirect()->back()->with('error', $attemptLogin->message)->withInput();
    } else {

      session(['auth_user_id' => $attemptLogin->data->profileId]);
      session(['auth_user_email' => $attemptLogin->data->email]);
      session(['auth_user_role' => $attemptLogin->data->userRole]);
      session(['auth_user_type' => $attemptLogin->data->userType != null ? $attemptLogin->data->userType : $attemptLogin->data->userRole]);
      session(['auth_user_tokin' => $attemptLogin->sessionId]);
      session(['auth_user_name' => $attemptLogin->data->userFullName]);

      if ($attemptLogin->data->userRole == "Buyer") {
        // dd("I got to the buyer new wizard");
        return redirect()->route('buyer_new_wizard');
      } else {
        return redirect()->route('sellersDashboardHome');
      }
    }
  }

  public function logout(Request $request)
  {
    $helper = new Helper();
    $logout = $helper->clearLoginSession();
    //  dd($logout);

    return view('login_page');
  }

  public function passwordResetEmail(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|string|email|max:255|'
    ]);

    $helper = new Helper();

    $payload = array("email" => $request->email);
    $attemptEmail = $helper->hitCoffeePlugEndpoint($payload, "request-reset-password");
    // dd($attemptEmail,$payload);
    if (!isset($attemptEmail->statusCode)) {
      return redirect()->back()->with('error', "Password reset failed")->withInput();
    }

    if ($attemptEmail->statusCode != 200) {
      return redirect()->back()->with('error', $attemptEmail->message)->withInput();
    } else {
      return redirect()->route('login_page')->with('password_reset_successful', "Password reset link sent successfully")->withInput();
    }
  }

  public function resetPassword($token, $encoded_email)
  {

    return view('password_reset', compact('token', 'encoded_email'));
  }

  public function newPassword(Request $request)
  {

    $this->validate($request, [
      'password' => 'required|confirmed|min:6'
    ]);

    $helper = new Helper();

    $payload = array("newPassword" => $request->password);
    $attemptEmail = $helper->hitCoffeePlugEndpoint($payload, "reset-password/" . $request->token . "/" . $request->email);
    // dd($attemptEmail,$payload);
    if (!isset($attemptEmail->statusCode)) {
      return redirect()->route('login_page')->with('error', "Password reset failed");
    }

    if ($attemptEmail->statusCode != 200) {
      return redirect()->route('login_page')->with('error', $attemptEmail->message);
    } else {
      return redirect()->route('login_page')->with('password_reset_successful', $attemptEmail->message);
    }


    return view('password_reset', compact('token'));
  }
}
