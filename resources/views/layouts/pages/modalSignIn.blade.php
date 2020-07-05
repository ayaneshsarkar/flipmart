@php
  $sessionClass = 'success';
  
  if(Session::get('signinError')) {
    $sessionClass = 'error';
  } elseif (Session::get('verify')) {
    $sessionClass = 'warning';
  } else {
    $sessionClass = 'success';
  }

@endphp

<div id="modalSignIn" class="my-modal-body {{ ($login == TRUE) ? 'signInModal' : '' }}">

  {{ Form::open(['action' => 'AuthController@login', 'method' => 'POST']) }}
    <div class="my-modal-content">
      <span class="closeBtn">&times;</span>
      <h4 class="m-text-26 p-t-20 p-b-20" id="modalTitle">SIGN IN</h4>

      @if (Session::get('signinError') || Session::get('verify') || Session::get('verifySuccess'))

      <div class="modalSession {{ $sessionClass }} m-b-30">
        <div class="modalSessionInner">
          <p class="modalSessionText">
            {{  (!empty(Session::get('signinError'))) ? Session::get('signinError') : '' }}
            {{  (!empty(Session::get('verify'))) ? Session::get('verify') : '' }}
            {{  (!empty(Session::get('verifySuccess'))) ? Session::get('verifySuccess') : '' }}
          </p>
          <p class="modalSessionText modalCross">x</p>
        </div>
      </div>

      @endif

      <div class="bo4 of-hidden size15 {{ ($errors->has('email')) ? '' : 'm-b-30' }} modal-input-body">
        <input type="email" class="sizefull s-text-7 p-r-20 p-l-20 modal-input{{ ($errors->has('email')) ? '-danger' : '' }}" 
        placeholder="Email" name="email" value={{ old('email') }}>
      </div>
      @error('email')<span class="invalid-text">{{$message}}</span>@enderror

      <div id="password" class="bo4 of-hidden size15 {{ ($errors->has('password')) ? '' : 'm-b-30' }}  modal-input-body">
        <input type="password" class="sizefull s-text-7 p-r-20 p-l-20 modal-input{{ ($errors->has('password')) ? '-danger' : '' }}" 
        placeholder="Password" name="password">
      </div>
      @error('password')<span class="invalid-text">{{$message}}</span>@enderror

      <div style="width: 100%;">
        <button type="submit" id="modalSignInButton" class="flex-c-m size2 bg1 bo-rad-23 hov1 m-text3 trans-0-4" 
        style="border-radius: 100px">
          SIGN IN
        </button>
      </div>
    </div>
  {{ Form::close() }}
</div>