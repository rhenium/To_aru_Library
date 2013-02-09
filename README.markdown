# License
__CC0__ (No Rights Reserved)

***
***
***

# To_aru_Library

PHPにあると思ったけど無かった的な関数・クラス集。
以前はTwitter関連も全部ここにまとめてありましたが分離させました。

## [array_slide]

### 関数仕様
bool __array\_slide__ (array _&$array_ , mixed _$key_ , int _$amount_ [, bool _$search\_target\_with\_order=false_ ] )

### 概要
参照渡しされた配列のうち指定した1つの要素を、任意の量で前後に移動させることが出来ます。

## [VirtualForm]

### メソッド仕様
($vfはクラスのインスタンス)  
string $vf-> __createLink__ ( array _$data_ [, 
string _$caption='submit'_ [, string _$action=''_ [, 
string _$method='POST'_ [, string _$target='\_self'_ [, 
string _$linkStyle=''_ [, string _$buttonStyle=''_ 
]]]]]] )

### 概　要
簡単にaタグでPOSTが出来るリンクを張れます。
多次元配列に対応しています。
JavaScriptが使えない場合はSubmitボタンで表示します。

[array_slide]: https://github.com/Certainist/To_aru_Library/blob/master/array_slide.php
[VirtualForm]: https://github.com/Certainist/To_aru_Library/blob/master/VirtualForm.php