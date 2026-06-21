<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X Mock API</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #000; color: #e7e9ea; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .container { max-width: 600px; padding: 40px 20px; text-align: center; }
        .logo { font-size: 48px; font-weight: 900; margin-bottom: 24px; }
        h1 { font-size: 28px; font-weight: 700; margin-bottom: 12px; }
        p { color: #71767b; margin-bottom: 32px; font-size: 15px; line-height: 1.6; }
        .endpoints { background: #16181c; border: 1px solid #2f3336; border-radius: 16px; padding: 24px; text-align: left; }
        .endpoints h2 { font-size: 18px; margin-bottom: 16px; color: #1d9bf0; }
        .endpoint-group { margin-bottom: 20px; }
        .endpoint-group h3 { font-size: 13px; color: #71767b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .endpoint { display: flex; align-items: center; gap: 8px; padding: 6px 0; border-bottom: 1px solid #2f3336; font-size: 13px; }
        .endpoint:last-child { border-bottom: none; }
        .method { font-weight: 700; min-width: 50px; }
        .method.get { color: #00ba7c; }
        .method.post { color: #1d9bf0; }
        .method.put { color: #f59e0b; }
        .method.delete { color: #f4212e; }
        .path { color: #e7e9ea; font-family: monospace; }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">𝕏</div>
    <h1>X Mock API</h1>
    <p>X (旧Twitter) のモック APIサーバーです。<br>以下のエンドポイントが利用可能です。</p>
    <div class="endpoints">
        <h2>API エンドポイント一覧</h2>
        <div class="endpoint-group">
            <h3>認証</h3>
            <div class="endpoint"><span class="method post">POST</span><span class="path">/api/register</span></div>
            <div class="endpoint"><span class="method post">POST</span><span class="path">/api/login</span></div>
            <div class="endpoint"><span class="method post">POST</span><span class="path">/api/logout</span></div>
            <div class="endpoint"><span class="method get">GET</span><span class="path">/api/me</span></div>
        </div>
        <div class="endpoint-group">
            <h3>投稿</h3>
            <div class="endpoint"><span class="method get">GET</span><span class="path">/api/timeline</span></div>
            <div class="endpoint"><span class="method get">GET</span><span class="path">/api/posts</span></div>
            <div class="endpoint"><span class="method post">POST</span><span class="path">/api/posts</span></div>
            <div class="endpoint"><span class="method get">GET</span><span class="path">/api/posts/{id}</span></div>
            <div class="endpoint"><span class="method put">PUT</span><span class="path">/api/posts/{id}</span></div>
            <div class="endpoint"><span class="method delete">DEL</span><span class="path">/api/posts/{id}</span></div>
        </div>
        <div class="endpoint-group">
            <h3>いいね</h3>
            <div class="endpoint"><span class="method post">POST</span><span class="path">/api/posts/{id}/like</span></div>
            <div class="endpoint"><span class="method get">GET</span><span class="path">/api/likes</span></div>
            <div class="endpoint"><span class="method get">GET</span><span class="path">/api/posts/{id}/likes</span></div>
        </div>
        <div class="endpoint-group">
            <h3>コメント</h3>
            <div class="endpoint"><span class="method get">GET</span><span class="path">/api/posts/{id}/comments</span></div>
            <div class="endpoint"><span class="method post">POST</span><span class="path">/api/posts/{id}/comments</span></div>
            <div class="endpoint"><span class="method delete">DEL</span><span class="path">/api/posts/{id}/comments/{cid}</span></div>
        </div>
        <div class="endpoint-group">
            <h3>フォロー・ユーザー</h3>
            <div class="endpoint"><span class="method post">POST</span><span class="path">/api/users/{username}/follow</span></div>
            <div class="endpoint"><span class="method get">GET</span><span class="path">/api/users/{username}/followers</span></div>
            <div class="endpoint"><span class="method get">GET</span><span class="path">/api/users/{username}/following</span></div>
            <div class="endpoint"><span class="method get">GET</span><span class="path">/api/users/{username}</span></div>
            <div class="endpoint"><span class="method get">GET</span><span class="path">/api/users/search?q=</span></div>
        </div>
    </div>
</div>
</body>
</html>
