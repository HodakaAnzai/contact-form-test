@extends('layout.app')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection

@section('logoutbutton')
<form class="form" action="/logout" method="post">
    @csrf
    <button class="header_button">ログアウト</button>
</form>

@endsection

@section('content')
<div class="admin">
    <h2 class="admin__title">Admin</h2>

    <form class="admin__search-form" action="/search" method="post">
        @csrf
        <div class="search-form__section">
            <div class="search-form__group">
                <label class="form__label" for="name">名前</label>
                <input class="input-form input-form__name" type="text" name="word" class="form__input" id="name"
                    placeholder="名前を検索" value="{{old('word')}}" />
            </div>
        </div>
        <div class="search-form__section--gender">
            <div class="search-form__group">
                <label class="form__label" for="gender">性別</label>
                <select class="input-form input-form__gender" id="gender" name="gender">
                    <option value="" disabled {{ old('gender') === null ? 'selected' : '' }}
                        class="input-form input-form__gender--color">
                        性別を選択
                    </option>
                    <option value="0" {{ old('gender') == "0" ? 'selected' : '' }}>全て</option>
                    <option value="1" {{ old('gender') == "1" ? 'selected' : '' }}>男性</option>
                    <option value="2" {{ old('gender') == "2" ? 'selected' : '' }}>女性</option>
                    <option value="3" {{ old('gender') == "3" ? 'selected' : '' }}>その他</option>
                </select>
            </div>
        </div>
        <div class="search-form__section--id">
            <div class="search-form__group">
                <label class="form__label" for="id">お問い合わせの種類</label>
                <select class="input-form input-form__id" name="category_id">
                    <option disabled selected class="input-form input-form__id--color" name="category_id">お問い合わせの種類を選択
                    </option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{old('category_id') == $category->id ? 'selected' : ''}}>
                            {{$category->content }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="search-form__section--date">
            <div class="search-form__group">
                <label class="form__label" for="date">日付</label>
                <input class="input-form input-form__date" type="date" name="date" id="date" value="{{old('date')}}">
            </div>
        </div>
        <div class="search-form__group">
            <button type="submit" class="search-form__group--submit"><i class="bi bi-search"></i></button>
        </div>
    </form>

    <div class="admin__from-erea">
        @if (!empty($searchConditions))
            <div class="search-form__result">
                @if (!empty($searchConditions['word']))
                    <p class="search-form__result-text">"{{ $searchConditions['word'] }}"</p>
                @endif
                @if (!empty($searchConditions['gender']))
                    <p class="search-form__result-text">
                        @if ($searchConditions['gender'] == 1)
                            "男性"
                        @elseif ($searchConditions['gender'] == 2)
                            "女性"
                        @else
                            "その他"
                        @endif
                    </p>
                @endif
                @if (!empty($searchConditions['category_id']))
                    <p class="search-form__result-text">
                        "{{ optional($categories->firstWhere('id', $searchConditions['category_id']))->content ?? '不明' }}""
                    </p>
                @endif
                @if (!empty($searchConditions['date']))
                    <p class="search-form__result-text">"{{ $searchConditions['date'] }}"</p>
                @endif
                <p class="search-form__result--defalt">の検索結果</p>
            </div>
            <form class="search-form__reset" action="/reset" method="post">
                @csrf
                <i class="bi bi-arrow-clockwise"></i>
                <input class="search-form__reset--btn" type="submit" value="検索条件をリセット" name="reset">
            </form>
        @endif
    </div>

    <div clas="export-form">
        <form action="/export" method="post">
            @csrf
            <input type="hidden" name="word" value="{{ $searchConditions['word'] ?? '' }}">
            <input type="hidden" name="gender" value="{{ $searchConditions['gender'] ?? '' }}">
            <input type="hidden" name="category_id" value="{{ $searchConditions['category_id'] ?? '' }}">
            <input type="hidden" name="date" value="{{ $searchConditions['date'] ?? '' }}">
            <button type="submit" value="エクスポート" class="export-form__btn">エクスポート <i class="bi bi-download"></i></button>
        </form>
    </div>

    <table class="admin__table">
        <tr class="admin__row">
            <th class="admin__label">お名前</th>
            <th class="admin__label">性別</th>
            <th class="admin__label">メールアドレス</th>
            <th class="admin__label">お問い合わせの種類</th>
            <th class="admin__label"></th>
            </th>
        </tr>
        @foreach ($contacts as $contact)
            <tr class="admin__row">
                <td class="admin__data">{{$contact->last_name}} {{$contact->first_name}}</td>
                <td class="admin__data">
                    @if($contact->gender == 1)
                        男性
                    @elseif($contact->gender == 2)
                        女性
                    @else
                        その他
                    @endif
                </td>
                <td class="admin__data">{{$contact->email}}</td>
                <td class="admin__data">{{$contact->category->content}}</td>
                <td class="admin__data">
                    <a class="admin__detail-btn" href="#{{$contact->id}}">詳細を見る</a>
                </td>
            </tr>
            <div class="modal" id="{{$contact->id}}">
                <form class="modal-form" action="/delete" method="post">
                    @csrf
                    <div class="modal-form__group">
                        <label class="modal-form__label">お名前</label>
                        <p class="modal-form__text">{{$contact->last_name}} {{$contact->first_name}}</p>
                    </div>
                    <div class="modal-form__group">
                        <label class="modal-form__label">性別</label>
                        <p class="modal-form__text">
                            @if($contact->gender == 1)
                                男性
                            @elseif($contact->gender == 2)
                                女性
                            @else
                                その他
                            @endif
                        </p>
                    </div>
                    <div class="modal-form__group">
                        <label class="modal-form__label">メールアドレス</label>
                        <p class="modal-form__text">{{$contact->email}}</p>
                    </div>
                    <div class="modal-form__group">
                        <label class="modal-form__label">電話番号</label>
                        <p class="modal-form__text">{{$contact->tel}}</p>
                    </div>
                    <div class="modal-form__group">
                        <label class="modal-form__label">住所</label>
                        <p class="modal-form__text">{{$contact->address}}</p>
                    </div>
                    <div class="modal-form__group">
                        <label class="modal-form__label">建物名</label>
                        <p class="modal-form__text">{{$contact->building}}</p>
                    </div>
                    <div class="modal-form__group">
                        <label class="modal-form__label">お問い合わせの種類</label>
                        <p class="modal-form__text">{{$contact->category->content}}</p>
                    </div>
                    <div class="modal-form__group">
                        <label class="modal-form__label">お問い合わせ内容</label>
                        <p class="modal-form__text">{{$contact->detail}}</p>
                    </div>
                    <div class="model-form__btn-area">
                        <a href="/admin" class="model-form__btn">戻る</a>
                        <input type="hidden" name="id" value="{{$contact->id}}" />
                        <button class="model-form__btn--delete" type="submit" name="submit">削除</button>
                    </div>
                </form>
            </div>
        @endforeach
    </table>
    {{$contacts->links()}}
</div>
@endsection