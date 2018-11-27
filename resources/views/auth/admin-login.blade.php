@extends('layouts.admin-login')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Унесите податке</h3>
                </div>
                <div class="panel-body">
                  <form method="POST" action="{{ route('admin.login.submit') }}">
                        @csrf
                        <fieldset>
                            <div class="form-group">
                              <input id="email" class="form-control" type="email" placeholder="E-маил" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                              @if ($errors->has('email'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                              @endif
                            </div>
                            <div class="form-group">
                                <input id="password" placeholder="Лозинка" class="form-control" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="checkbox">
                                <label>
                                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                  Запамти ме
                                </label>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button type="submit" class="btn btn-primary">
                                {{ __('Пријави се') }}
                            </button>
                            <a class="btn btn-link" href="{{ route('admin.password.request') }}">
                                {{ __('Заборављена лозинка?') }}
                            </a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
