<!DOCTYPE html>
<html>
<head>
  @include('layouts.header')
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <p>{{\Config::get('app.name')}}</p>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <h4 class="login-box-msg">Account Verification</h4>
        <div class="input-group mb-3">
          @if($user['status']==1)
            <p><strong>Congratulations! </strong> your account has been successfully verified.</p>
          @else
            <div class="content-header">
              <strong> OPPS! SOMETHING WENT WRONG</strong>
              <p> User not found, please try again</p>
            </div>
          @endif
        </div>
    </div>
  </div>
</div>
</body>
</html>