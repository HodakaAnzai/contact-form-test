@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
<div class="contact">
    <h2 class="contact_title">Contact</h2>
    <div class="contact-form">
        <form action="/confirm" method="post">
            @csrf
            <div class="contact-form__group">
                <label class="contact-form__label" for="last_name">お名前<span
                        class="contact-form__required">※</span></label>
                <div class="input-form__first-name">
                    <input class="contact-form__input contact-form__input-name" type="text" name="last_name"
                        id="last_name" placeholder=" 例：山田" value="{{ old('last_name') }}" />
                    @error('last_name')
                        <p class="contact-form__error">
                            {{$message}}
                        </p>
                    @enderror
                </div>
                <div class="input-form__last-name">
                    <input class="contact-form__input contact-form__input-name" type="text" name="first_name"
                        id="last_name" placeholder=" 例：太郎" value="{{ old('first_name') }}" />
                    @error('first_name')
                        <p class="contact-form__error">
                            {{$message}}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="contact-form__group">
                <label class="contact-form__label" for="gender">性別<span class="contact-form__required">※</span></label>
                <div class="input-form__gender">
                    <label class="contact-form__label--gender"><input class="contact-form__input-gender" type="radio"
                            name="gender" value="1" {{ old('gender') == '1' ? 'checked' : '' }} />男性</label>
                    <label class="contact-form__label--gender"><input class="contact-form__input-gender" type="radio"
                            name="gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }} />女性</label>
                    <label class="contact-form__label--gender"><input class="contact-form__input-gender" type="radio"
                            name="gender" value="3" {{ old('gender') == '3' ? 'checked' : '' }} />その他</label>
                    @error('gender')
                        <p class="contact-form__error">
                            {{$message}}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="contact-form__group">
                <label class="contact-form__label" for="email">メールアドレス<span
                        class="contact-form__required">※</span></label>
                <div class="input-form__last-name">
                    <input class="contact-form__input contact-form__input-email" type="email" name="email" id="email"
                        placeholder=" 例:test@example.com" value="{{ old('email') }}" />
                    @error('email')
                        <p class="contact-form__error">
                            {{$message}}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="contact-form__group">
                <label class="contact-form__label" for="tel">電話番号<span class="contact-form__required">※</span></label>
                <div class="input-form__tel">
                    <input class="contact-form__input contact-form__input-tel" type="tel" name="tel1" id="tel1"
                        placeholder=" 080" value="{{ old('tel1') }}" />
                    <span class="contact-form__label--line">-</span>
                    <input class="contact-form__input contact-form__input-tel" type="tel" name="tel2" id="tel2"
                        placeholder=" 1234" value="{{ old('tel2') }}" />

                    <span class="contact-form__label--line">-</span>
                    <input class="contact-form__input contact-form__input-tel" type="tel" name="tel3" id="tel3"
                        placeholder=" 5678" value="{{ old('tel3') }}" />
                    <p class="contact-form__error">
                        @if ($errors->has('tel1'))
                            {{$errors->first('tel1')}}
                        @elseif ($errors->has('tel2'))
                            {{$errors->first('tel2')}}
                        @else
                            {{$errors->first('tel3')}}
                        @endif
                    </p>
                </div>
            </div>

            <div class="contact-form__group">
                <label class="contact-form__label" for="address">住所<span class="contact-form__required">※</span></label>
                <div class="input-form__address">
                    <input class="contact-form__input contact-form__input-address" type="text" name="address"
                        id="address" placeholder=" 例:東京都渋谷区千駄ヶ谷1 2 3" value="{{ old('address') }}" />
                    @error('address')
                        <p class="contact-form__error">
                            {{$message}}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="contact-form__group">
                <label class="contact-form__label" for="building">建物名</label>
                <input class="contact-form__input contact-form__input-building" type="text" name="building"
                    id="building" placeholder=" 例:千駄ヶ谷マンション101" value="{{ old('building') }}" />
            </div>

            <div class="contact-form__group">
                <label class="contact-form__label" for="category">お問い合わせの種類<span
                        class="contact-form__required">※</span></label>
                <div class="input-form__select">
                    <select class="contact-form__select" name="category_id" id="category">
                        <option disabled selected>選択してください</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->content }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="contact-form__error">
                            {{$message}}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="contact-form__group">
                <label class="contact-form__label" for="detail">お問い合わせ内容<span
                        class="contact-form__required">※</span></label>
                <div class="input-form__detail">
                    <textarea class="contact-form__textarea" name="detail" id="detail"
                        placeholder=" お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                    @error('detail')
                        <p class="contact-form__error">
                            {{$message}}
                        </p>
                    @enderror
                </div>
            </div>


            <div class="contact-form__group">
                <input class="contact-form__submit" type="submit" value="確認画面">
            </div>
        </form>
    </div>
</div>
@endsection