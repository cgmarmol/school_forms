<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ASCT Login</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
          <div class="login-logo">
            <a href="#">
              <img src="{{ asset('images/ascot_logo.png') }}" alt="ASCOT Logo">
            </a>
          </div>
          <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <form>
              <div class="form-group has-feedback">
                <input type="email" class="user-email form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="user-password form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </form>
            <br>
            <a href="#">I forgot my password</a><br>
            <a href="register.html" class="text-center">Register a new membership</a>
          </div>
        </div>
        <script>
        $(function() {

          var cookies = document.cookie.split(';');
          var token = null;
          for(i in cookies) {
            if(cookies[i].includes('authentication-token=')) {
              token = cookies[i].replace('authentication-token=', '');
              break;
            }
          }
          if(token) {
            $.get('{{ url("api/authentication/user") }}?token='+token, function() {
              location.href = '{{ url("/") }}';
            });
          }

          $('form').submit(function(e) {
            e.preventDefault();
            var email = $('.user-email', $(this)).val();
            var password = $('.user-password', $(this)).val();
            $.post('{{ url("api/login") }}', {email: email, password: password}, function(r) {
              document.cookie = 'authentication-token='+r.token;
              location.href = '{{ url("/") }}';
            });
          });
        });
        </script>
    </body>
</html>
