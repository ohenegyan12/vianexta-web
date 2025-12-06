<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class ManualRegistrationController extends Controller
{
    public function saveLanguage(Request $request)
    {
        $this->validate($request, [
            'language' => 'required'
        ]);
        session(['language' => $request->language]);

        return view('account_type');
    }

    public function saveAccountType(Request $request)
    {
        $this->validate($request, [
            'account_type' => 'required'
        ]);

        $account_type = $request->account_type;
        $language = $request->language;
        session(['account_type' => $account_type]);

        return redirect()->route('register_step_1');
    }

    public function savePersonalData(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required | max: 20',
            'last_name' => 'required | max: 20',
            'email' => 'required|email',
            'phone_number' => 'required| min:10 | max: 30',
            'password' => 'required|confirmed|min:6'
        ]);

        session(['first_name' => $request->first_name]);
        session(['last_name' => $request->last_name]);
        session(['email' => $request->email]);
        session(['phone_number' => $request->phone_number]);
        session(['password' => $request->password]);
        session(['newsletter_optin' => $request->has('newsletter_optin')]);

        return redirect()->route('register_step_2');
    }

    public function saveBusinessData(Request $request)
    {

        $this->validate($request, [
            'business_name' => 'required',
            'business_type' => 'required',
            'billingAddressLine1' => 'required',
            'billingCountry' => 'required',
            'billingCity' => 'required',
            'billingState' => 'required',
            'billingZipCode' => 'required'
            // 'tax_id' => 'required'
        ]);
        $helper = new Helper();
        session(['business_name' => $request->business_name]);
        session(['business_type' => $request->business_type]);

        session(['billingCountry' => $request->billingCountry]);
        session(['billingAddressLine1' => $request->billingAddressLine1]);
        session(['billingAddressLine2' => $request->billingAddressLine2]);
        session(['billingCity' => $request->billingCity]);
        session(['billingState' => $request->billingState]);
        session(['billingZipCode' => $request->billingZipCode]);

        session(['shippingCountry' => $request->shippingCountry]);
        session(['shippingAddressLine1' => $request->shippingAddressLine1]);
        session(['shippingAddressLine2' => $request->shippingAddressLine2]);
        session(['shippingCity' => $request->shippingCity]);
        session(['shippingState' => $request->shippingState]);
        session(['shippingZipCode' => $request->shippingZipCode]);

        session(['tax_id' => $request->tax_id]);

        if (session('account_type') == 'Roaster') {
            $user_role = "Supplier";
        } else if (session('account_type') == 'Cafe') {
            $user_role = "Buyer";
        } else {
            $user_role = session('account_type');
        }


        $payload = array(
            "email" => session('email'),
            "password" => session('password'),
            "firstName" => session('first_name'),
            "lastName" => session('last_name'),
            "receiveEmailNotifications" => true,
            "preferredLanguage" => session('language'),
            "phoneNumber" => session('phone_number'),
            "businessName" => session('business_name'),
            "businessType" => session('business_type'),

            "billingCountry" => session('billingCountry'),
            "billingAddressLine1" => session('billingAddressLine1'),
            "billingAddressLine2" => session('billingAddressLine2'),
            "billingCity" => session('billingCity'),
            "billingState" => session('billingState'),
            "billingZipCode" => session('billingZipCode'),

            "shippingCountry" => session('shippingCountry'),
            "shippingAddressLine1" => session('shippingAddressLine1'),
            "shippingAddressLine2" => session('shippingAddressLine2'),
            "shippingCity" => session('shippingCity'),
            "shippingState" => session('shippingState'),
            "shippingZipCode" => session('shippingZipCode'),

            "taxIdNumber" => session('tax_id'),
            "userRole" => $user_role,
            "userType" => session('account_type')
        );
        //    dd($payload);
        $attemptRegister = $helper->hitCoffeePlugEndpoint($payload, "signup");
        // dd($attemptRegister);
        if ($attemptRegister->statusCode != 200) {
            return redirect()->back()->with('error', $attemptRegister->message)->withInput();
        } else {
            // Subscribe to newsletter if user opted in
            if (session('newsletter_optin')) {
                $newsletterPayload = array("email" => session('email'));
                $newsletterResult = $helper->hitCoffeePlugEndpoint($newsletterPayload, "subscribe-newsletter");
                // Note: We don't redirect on newsletter failure as registration was successful
            }
            
            $helper->clearSession();
            return redirect()->route('register_step_2')->with('success', 'Registration completed successfully! You can now proceed to login.');
        }
    }

    public function saveAccountDetails(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'password' => 'required'
        ]);

        $helper = new Helper();
        if ($request->account_type == 'Roaster') {
            $user_role = "Supplier";
        } else if ($request->account_type == 'Cafe') {
            $user_role = "Buyer";
        } else {
            $user_role = $request->account_type;
        }

        $payload = array(
            "email" => $request->email,
            "password" => $request->password,
            "firstName" => $request->first_name,
            "lastName" => $request->last_name,
            "receiveEmailNotifications" => true,
            "billingCountry" => $request->country,
            "billingCity" => $request->city,
            "billingState" => $request->state,
            "preferredLanguage" => $request->language,
            "phoneNumber" => $request->phone_number,
            "businessName" => $request->business_name,
            "businessType" => $request->business_type,
            "billingZipCode" => $request->postal_code,
            "taxIdNumber" => $request->tax_id,
            "billingAddressLine1" => $request->address_line1,
            "billingAddressLine2" => $request->address_line2,
            "userRole" => $user_role,
            "userType" => $request->account_type
        );

        $attemptRegister = $helper->hitCoffeePlugEndpoint($payload, "signup");
        //  $helper->clearSession();
        //  return redirect()->back()->with('success','registration successful');
        //  dd($payload,$attemptRegister);
        if ($attemptRegister->statusCode != 200) {
            return redirect()->back()->with('error', $attemptRegister->message)->withInput();
        } else {
            $helper->clearSession();
            return redirect()->back()->with('success', 'registration successful');
            //  session(['registration_successful' => 'registration successful']);
            //  return redirect()->route('login_page');
        }
    }

    public function manualRegUsers()
    {
        $helper = new Helper();

        foreach ($helper->getManualUsersData() as $userdata) {
            // dd($userdata);
            $attemptRegister = $helper->hitCoffeePlugEndpoint($userdata, "signup");

            //  dd($attemptRegister);
            if ($attemptRegister->statusCode != 200) {
                echo "error saving user registration /n";
            } else {
                echo "saved user details successfully /n";
            }
        }
    }
}
