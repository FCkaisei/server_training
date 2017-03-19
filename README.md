# server_training

## Andorid niyoru Test branch desu

##STATUS
### 完了
1. つぶやき機能
1. フォロー機能
1. タイムライン取得
1. アンフォロー
1. ユーザー登録
1. ログイン機能
1. 画像追加
1. ページング(次へボタンなし)

### ログインページ
```
server_training/html/login.html
```

### MYSQL構造
```
DB:Twitter

table:
	user_data	:user情報を管理（画像データあり)
	tweet_data	:誰が何時何をつぶやいたかを管理
	follow_data	:誰が誰をフォローしているかを管理
```
