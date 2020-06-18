
<div id="modalSignUp" class="my-modal-body {{ ($register == TRUE) ? 'registerModal' : '' }}">

  {{ Form::open(['action' => 'AuthController@register', 'method' => 'POST']) }}
    <div class="my-modal-content">
      <span class="closeBtn">&times;</span>
      <h4 class="m-text-26 p-t-20 p-b-30" id="modalTitle">SIGN UP</h4>

      
      <div id="name" class="bo4 of-hidden {{ ($errors->has('name')) ? '' : 'm-b-30' }} size15 m-b-5">
        <input type="text" class="sizefull s-text-7 p-r-20 p-l-20 modal-input{{ ($errors->has('name')) ? '-danger' : '' }}" 
        placeholder="Name" name="name" value={{ old('name') }}>
      </div>
      @error('name')<span class="invalid-text">{{$message}}</span>@enderror

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

      <div id="confirm_password" class="bo4 of-hidden size15 {{ ($errors->has('confirm_password')) ? '' : 'm-b-30' }} modal-input-body">
        <input type="password" class="sizefull s-text-7 p-r-20 p-l-20 modal-input{{ ($errors->has('confirm_password')) ? '-danger' : '' }}" 
        placeholder="Confirm Password" name="confirm_password">
      </div>
      @error('confirm_password')<span class="invalid-text">{{$message}}</span>@enderror

      <div style="width: 100%;">
        <button type="submit" id="modalSignUpButton" class="flex-c-m size2 bg1 bo-rad-23 hov1 m-text3 trans-0-4" 
        style="border-radius: 100px">
          SIGN UP
        </button>
      </div>
    </div>
  {{ Form::close() }}
</div>