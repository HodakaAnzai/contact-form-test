@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="register-form__content">
  <div class="register-form__heading">
    <h2 class="register-form__title">ログイン</h2>
  </div>
  <form class="form" action="/login" method="post">
    @csrf
    <div class="form__group">
      <div class="form__group-title">
        <span class="form__label--item">メールアドレス</span>
      </div>
      <div class="form__input--text">
        <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力してください" />
      </div>
      <div class="form__error">
        @error('email')
        {{ $message }}
        @enderror
      </div>
    </div>
    <div class="form__group">
      <div class="form__group-title">
        <span class="form__label--item">パスワード</span>
      </div>
      <div class="form__input--text">
        <input type="password" name="password" placeholder="パスワードを入力してください" />
      </div>
      <div class="form__error">
        @error('password')
        {{ $message }}
        @enderror
      </div>
    </div>
    <div class="form__button">
      <button class="form__button-submit" type="submit">ログイン</button>
    </div>
  </form>
  <div class="login__link">
    <a class="login__button-submit" href="{{ route('register') }}">会員登録の方はこちら</a>
  </div>
</div>
@endsection
