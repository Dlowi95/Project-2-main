<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Customer;
use Exception;

class SocialAuthController extends Controller
{
    // Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
{
    try {
        // Lấy thông tin người dùng từ Google
        $customer = Socialite::driver('google')->user();

        // Truy xuất các thuộc tính của Google user, chẳng hạn như email, name và google_id
        $email = $customer->getEmail();    // Lấy email từ Google
        $name = $customer->getName();      // Lấy tên người dùng từ Google
        $googleId = $customer->getId();    // Lấy Google ID từ Google

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa
        $existingCustomer = Customer::where('email', $email)->first();

        if ($existingCustomer) {
            // Nếu đã tồn tại, đăng nhập người dùng này
            Auth::guard('customer')->login($existingCustomer);
        } else {
            // Nếu chưa có, tạo tài khoản mới
            $newCustomer = Customer::create([
                'name' => $name,
                'email' => $email,
                'google_id' => $googleId,
                'password' => bcrypt('123456dummy'),  // Mật khẩu giả hoặc có thể để trống
                'customer_catalogue_id' => 1,
            ]);

            // Đăng nhập người dùng mới
            Auth::guard('customer')->login($newCustomer);
        }

        // Chuyển hướng người dùng đến trang chính hoặc trang bạn muốn
        return redirect()->intended('/')->with('success','Đăng nhập thành công');;
    } catch (Exception $e) {
        // Nếu có lỗi, ghi lại log và chuyển hướng người dùng về trang login
        \Log::error('Error during Google login: ' . $e->getMessage());
        return redirect()->route('fe.auth.login')->with('error','Lỗi hệ thống. Vui lòng thử lại sau!');
    }
}


    // Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $customer = Socialite::driver('facebook')->user();

            $email = $customer->getEmail();
            $name = $customer->getName();
            $facebookId = $customer->getId();
            // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa
            $existingCustomer = Customer::where('email', $email)->first();

            if ($existingCustomer) {
            // Nếu đã tồn tại, đăng nhập người dùng này
            Auth::guard('customer')->login($existingCustomer);
            } else {
                $newCustomer = Customer::create([
                    'name' => $name,
                    'email' => $email,
                    'facebook_id' => $facebookId,
                    'password' => bcrypt('123456dummy'),
                    'customer_catalogue_id' => 1,
                ]);
                // Đăng nhập người dùng mới
                Auth::guard('customer')->login($newCustomer);
            }

            return redirect()->intended('/')->with('success','Đăng nhập thành công');
        } catch (Exception $e) {
            \Log::error('Error during Google login: ' . $e->getMessage());
            return redirect()->route('fe.auth.login')->with('error','Lỗi hệ thống. Vui lòng thử lại sau!');
        }
    }
}

