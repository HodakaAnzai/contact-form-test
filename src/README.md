# アプリケーション名
　お問い合わせフォーム

## 環境構築
  1.git clone git@github.com:HodakaAnzai/contact-form-test.git
  2.DockerDesktopを起動
  3.クローンしたconfirmation-contact-firmプロジェクト上で、以下のdockerコードを実行してください。
　　docker-compose up -d --build

## 使用技術(実行環境)
  php 8.4.1
  laravel 8.83.29
  mysql:8.0.26

## ER図
< - - - 作成したER図の画像 - - - >

## URL
・開発環境：http://localhost/
・phpMyAdmin:http://localhost:8080/

　お問い合わせフォーム入力ページ
　/
　お問い合わせフォーム確認ページ
　/confirm
　サンクスページ
　/thanks
　管理画面
　/admin
　新規登録
　/register
　ログイン
　/login