<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vesam24</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="parent">
        <div class="login-wrap">
            <div class="login-html">

                <div class="logo-name-container">
                    <img src="{{ asset('images/vesam-logo.jpg') }}" />
                    <label class="tab">وسام 24</label>
                </div>
                @if ($errors->has('email'))
                <div class="login-error-text text-center">{{ $errors->first('email') }}</div>
                @endif
                <form class="login-form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="sign-in-htm">
                        <div class="group">
                            <label for="email" class="label">پست الکترونیکی</label>



                            <input id="email" type="email" name="email" value="" required="required"
                                autofocus="autofocus" class="input">
                        </div>
                        <div class="group">

                            @if ($errors->has('password'))
                            <span>
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif

                            <label for="password" class="label">رمز عبور</label>
                            <input id="password" type="password" name="password" required="required" class="input"
                                data-type="password">
                        </div>
                        <div class="group">
                            <input id="check" type="checkbox" name="remember" class="check"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label for="check" class="remember-me-text"><span class="icon"></span>
                                مرا به خاطر بسپار
                            </label>
                        </div>
                        <div class="group">
                            <input type="submit" class="button" value="ورود">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>