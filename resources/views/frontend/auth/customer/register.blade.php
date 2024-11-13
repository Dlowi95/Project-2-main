<!DOCTYPE html>
<html lang="en">
    <head>

        <base href="{{ config('app.url') }}" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1,user-scalable=0">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <meta name="robots" content="index,follow"/>
        <meta name="author" content="{{ $system['homepage_company'] }}"/>
        <meta name="copyright" content="{{ $system['homepage_company'] }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="refresh" content="1800" />
        <link rel="icon" href="{{ $system['homepage_favicon'] }}" type="image/png" sizes="30x30">
        
        <!-- GOOGLE -->
        <title>{{ $seo['meta_title'] }}</title>
        <meta name="description"  content="{{ $seo['meta_description'] }}" />
        <meta name="keyword"  content="{{ $seo['meta_keyword'] }}" />
        <link rel="canonical" href="{{ $seo['canonical'] }}" />		
        <meta property="og:locale" content="vi_VN" />
        <!-- for Facebook -->
        <meta property="og:title" content="{{ $seo['meta_title'] }}" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="{{ $seo['meta_image'] }}" />
        <meta property="og:url" content="{{ $seo['canonical'] }}" />		
        <meta property="og:description" content="{{ $seo['meta_description'] }}" />
        <meta property="og:site_name" content="" />
        <meta property="fb:admins" content=""/>
        <meta property="fb:app_id" content="" />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="{{ $seo['meta_title'] }}" />
        <meta name="twitter:description" content="{{ $seo['meta_description'] }}" />
        <meta name="twitter:image" content="{{ $seo['meta_image'] }}" />
        
            <!-- Favicon -->
            <link rel="icon" type="image/png" href="https://example.com/path-to-your-favicon/favicon.ico"/>
        
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        
            <!-- Font Awesome -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
            <!-- Font -->
            <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
        
            <!-- Material Design Iconic Font -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
        
            <!-- Animate.css -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
        
            <!-- Hamburgers.css -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hamburgers/1.1.3/hamburgers.min.css">
        
            <!-- Animsition.css -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animsition/4.0.2/css/animsition.min.css">
        
            <!-- Select2 CSS -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
        
            <!-- Date Range Picker CSS -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css">
        
            <!-- Custom CSS -->
            <link rel="stylesheet" type="text/css" href="{{ asset('frontend/resources/css/util.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('frontend/resources/css/main.css') }}">
        </head>
<body>

    <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
        <div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
            <form class="login100-form validate-form" action="{{ route('customer.reg')}}" method="post">
                @csrf
                <span class="login100-form-title p-b-37">
                    Đăng Ký
                </span>
                <!-- Username -->
                <div class="wrap-input100 validate-input m-b-20" data-validate="Bạn chưa nhập Họ Tên">
                    <input class="input100" type="text" name="name" value="{{ old('name') }}" placeholder="Tên người dùng">
                    <span class="focus-input100"></span>
                </div>

                <!-- Email -->
                <div class="wrap-input100 validate-input m-b-20" data-validate="Bạn chưa nhập Email">
                    <input class="input100" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                    <span class="focus-input100"></span>
                </div>

                 <!-- Address -->
                 <div class="wrap-input100 validate-input m-b-20" data-validate="Bạn chưa nhập Địa chỉ">
                    <input class="input100" type="text" name="address" value="{{ old('address') }}"  placeholder="Địa chỉ">
                    <input type="hidden" name="customer_catalogue_id" value="1">
                    <span class="focus-input100"></span>
                </div>

                <!-- Password -->
                <div class="wrap-input100 validate-input m-b-20" data-validate="Bạn chưa nhập Mật khẩu">
                    <input class="input100" type="password" name="password" placeholder="Mật khẩu" autocomplete="off">
                    <span class="focus-input100"></span>
                </div>

                <!-- Confirm Password -->
                
                <div class="wrap-input100 validate-input m-b-20" 
                    data-validate="Bạn chưa nhập Nhập lại mật khẩu">
                    <input class="input100" type="password" name="re_password" placeholder="Nhập lại mật khẩu" autocomplete="off">
                    <span class="focus-input100"></span>
                </div>
                @if($errors->has('re_password'))
                    <span class="error-message">{{ $errors->first('re_password') }}</span>
                @endif



                <!-- Submit Button -->
                <div class="container-login100-form-btn">
                    <button type="submit" class="login100-form-btn">
                        Đăng ký
                    </button>
                </div>

                <div class="text-center p-t-57 p-b-20">
                    <span class="txt1">
                        Hoặc Đăng Ký với
                    </span>
                </div>

                <div class="flex-c p-b-50">
                    <a href="#" class="login100-social-item">
                        <i class="fa fa-facebook-f"></i>
                    </a>
                    <a href="#" class="login100-social-item">
                        <img src="{{ asset('frontend/resources/img/icon-google.png') }}" alt="GOOGLE">
                    </a>
                </div>

                <div class="text-center">
                    <a href="{{ route('fe.auth.login') }}" class="txt2 hov1">
                        Bạn đã có tài khoản?
                    </a>
                </div>
                <div class="text-center m-t-20">
					<small>{{ $system['homepage_brand'] }} © 2024</small>
				</div>
            </form>
        </div>
    </div>

    <div id="dropDownSelect1"></div>

</body>
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Animsition JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animsition/4.0.2/js/animsition.min.js"></script>

<!-- Popper.js (để hỗ trợ Bootstrap) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Moment.js (cho Date Range Picker) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<!-- Date Range Picker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>

<!-- Countdown Time (không có CDN chính thức, nên cần file gốc nếu bạn cần dùng) -->
<!-- <script src="vendor/countdowntime/countdowntime.js"></script> -->

<!-- Custom JS -->
<script src="{{ asset('frontend/resources/js/main.js') }}"></script>

<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-23581568-13');
</script>

<!-- Cloudflare Insights -->
<script defer src="https://static.cloudflareinsights.com/beacon.min.js" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"8dbccc891811a8e9","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"version":"2024.10.4","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>

</html>
