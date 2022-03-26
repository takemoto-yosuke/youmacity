<p align="center">
    <a href="https://youmacity.herokuapp.com/" target="_blank">
        <img src="/public/img/youma_logo.png" width="200">
    </a>
</p>

## youmacity概要
YouTubeにアップロードされている動画をまとめて管理することができる。（非公開動画でも可能）


## 表示画面設定ファイル

ログイン画面

- login.blade.php

新規登録画面

- register.blade.php

動画一覧表示画面

- index.blade.php

動画追加画面

- create.blade.php
- check.blade.php

編集画面（非公開動画タイトル）

- edit.blade.php

## データベース

users テーブル

- id → 主キー
- name → 登録者名
- email → 登録者メールアドレス
- password → 登録者パスワード
- created_at → timestamps
- updated_at → timestamps

manuals テーブル

- id → 主キー
- user_id → usersテーブルとの結合で利用
- title → 非公開動画のタイトル
- youtube_url → YouTube動画のURL
- created_at → timestamps
- updated_at → timestamps