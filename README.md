Flickr APIを利用して、指定ユーザの画像をランダムで取得、表示するWordPressプラグインです。
バージョン3.2.1でしか動作確認は行っていません。

# 必要環境

* [libcurl](http://www.php.net/manual/ja/book.curl.php)

# インストール

wp-content -> pluginsフォルダにアップロード、有効化を行うだけです。

# Flickr API

Flickr APIを利用するためにはFlickrのユーザ登録が必要です。

登録完了後、[The App Garden on Flickr](http://www.flickr.com/services/apps/create/)からAppを作成、APIキーを取得します。

# 設定

管理画面の「設定」のサブメニューに「Flickr Random Get」が追加されていますので、Flickr API Key、Flickr API Secret、Flickr User IDのそれぞれに値を入力します。

User IDは「38131765@N07」の様な形式になるのですが、Screen nameを設定している場合はFlickr上で確認を取ることが出来ないので、[こちらのサービス](http://idgettr.com/)より確認を取ると良いでしょう。

# 表示

表示させたい箇所で以下の様な記述を行います。

    <?php global $flickr; if(isset($flickr)) $flickr->makeImage(); ?>

# 備考

自分用に作っていたので、現状表示サイズが固定なのですが、また気が向いたらサイズ変更も出来るようにしたいなぁ、とか思っています。
どうしてもやりたい方は、「maikeImage」内の画像パスの一部（.jpgの直前の「z」）を変更するとサイズ変更が可能です。