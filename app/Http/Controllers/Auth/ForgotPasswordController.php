<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Models\User;
use SendGrid\Mail\Mail;
use SendGrid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;



class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

     /**
     * Display the password reset request form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'No user found with this email address']);
    }

    $token = app('auth.password.broker')->createToken($user);

    // Generate the reset password URL with a signed route
    $resetUrl = URL::signedRoute('password.reset', ['token' => $token]);

    // Prepare the email content
    $email = new Mail();
    $email->setFrom("devpooz.09@gmail.com", "Pavisa Sirirojvorakul");
    $email->setSubject("Reset Password");
    $email->addTo($user->email, $user->name);
    $email->addContent("text/plain", "Click the link to reset your password: " . $resetUrl);

    // Send the email using SendGrid
    $sendgrid = new SendGrid(config('sendgrid.api_key'));
    $response = $sendgrid->send($email);

    return view('auth.passwords.email')->with('user', $user);
}

}
