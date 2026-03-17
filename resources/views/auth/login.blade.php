<x-guest-layout>

<div class="form-container">
	<p class="title">Log In</p>
	<form class="form" method="POST" action="{{ route('login') }}">
    @csrf
		<div class="input-group">
			<label for="email">Username</label>
      <x-text-input id="email" class="input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="error"/>
    </div>
		<div class="input-group">
			<label for="password">Password</label>
      <x-text-input id="password" class="input"
            type="password"
            name="password"
            required autocomplete="current-password" />

      <x-input-error :messages="$errors->get('password')" class="error" />
    </div>
    <div for="remember_me" class="remember_me">
      <input id="remember_me" type="checkbox" name="remember">
      <span>{{ __('Remember me') }}</span>
    </div>

    <x-primary-button class="sign">
      {{ __('Log in') }}
    </x-primary-button>
	</form>
</div>

<div class="form-container">
    <img src="/img/Fast_One_Logo_txt.png" alt="">
    <div id="page">
      <div id="container">
          <div id="ring"></div>
          <div id="ring"></div>
          <div id="ring"></div>
          <div id="ring"></div>
          <div id="h3">Welcome Back!</div>
      </div>
    </div>
</div>
    
</x-guest-layout>
