<div class="header-account header-account-dropdown">
  <ul class="header-account-wrapItem">
    <li class="header-account-item">
      <a class="header-account-text" href="{{ URL::to('/admin') }}">My Account</a>
    </li>

    <li class="header-account-item">
      <a class="header-account-text" id="logoutText" style="cursor: pointer;">Logout</a>
      {{ Form::open(['action' => 'AuthController@logout', 'method' => 'POST', 'style' => 'display: none', 'id' => 'logoutForm']) }}
        <input type="hidden" name="logout" id="logout" value="logout">
      {{ Form::close() }}
    </li>
  </ul>
</div>