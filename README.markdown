# License
__CC0__ (No Rights Reserved)

***
***
***

# To_aru_Library

PHPにあると思ったけど無かった的な関数・クラス集。  
以前はTwitter関連も全部ここにまとめてありましたが分離させました。

## [EasyCrypt]

### メソッド仕様
string EasyCrypt:: __encrypt__ (string $data, string $salt)  
string EasyCrypt:: __decrypt__ (string $data, string $salt)

### 概　要

暗号化と復号化を簡単に行えるクラスです。


### 使用例
コード

    <?php
    
    $data = 'This is a very secret data.';
    $salt = 'This is a very secret key.' ;
    
    $enc = EasyCrypt::encrypt($data,$salt);
    $dec = EasyCrypt::decrypt($enc, $salt);
    
    var_dump($data,$enc,$dec);
    
実行結果

    string(27) "This is a very secret data."
    string(89) "DCqphIJA2iTVf8WviemKp0KAU7+tcUUo2pVfLkYF8Sg=-3LLX6qY06882iltW5Wu8RycNgSJY0liNqZWnXI25isA="
    string(27) "This is a very secret data."

## [array_slide]

### 関数仕様
bool __array\_slide__ (array _&$array_ , mixed _$key_ , int _$amount_ [, bool _$search\_target\_with\_order=false_ ] )

### 概要
参照渡しされた配列のうち指定した1つの要素を、任意の量で前後に移動させることが出来ます。

### 使用例
コード

    <?php
    
    $arr = array('ド'=>'ドーナツ','レ'=>'レニウム','ミ'=>'ミカン','ファ'=>'ふぁぼれよ','ソ'=>'蒼井そら');
    var_dump($arr);
    array_slide($arr,'レ',2);
    var_dump($arr);
    array_slide($arr,3,999,true);
    var_dump($arr);
    array_slide($arr,'レ',-2,true);
    var_dump($arr);
    
実行結果

    array(5) {
      ["ド"]=>
      string(12) "ドーナツ"
      ["レ"]=>
      string(12) "レニウム"
      ["ミ"]=>
      string(9) "ミカン"
      ["ファ"]=>
      string(15) "ふぁぼれよ"
      ["ソ"]=>
      string(12) "蒼井そら"
    }
    array(5) {
      ["ド"]=>
      string(12) "ドーナツ"
      ["ミ"]=>
      string(9) "ミカン"
      ["ファ"]=>
      string(15) "ふぁぼれよ"
      ["レ"]=>
      string(12) "レニウム"
      ["ソ"]=>
      string(12) "蒼井そら"
    }
    array(5) {
      ["ド"]=>
      string(12) "ドーナツ"
      ["ミ"]=>
      string(9) "ミカン"
      ["ファ"]=>
      string(15) "ふぁぼれよ"
      ["ソ"]=>
      string(12) "蒼井そら"
      ["レ"]=>
      string(12) "レニウム"
    }
    array(5) {
      ["ド"]=>
      string(12) "ドーナツ"
      ["ミ"]=>
      string(9) "ミカン"
      ["レ"]=>
      string(12) "レニウム"
      ["ファ"]=>
      string(15) "ふぁぼれよ"
      ["ソ"]=>
      string(12) "蒼井そら"
    }

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

### 使用例
コード

    $post = array(
      'tokens' => array(
        'access_token'        => '&&&',
        'access_token_secret' => 'pass'
      ),
      'foo' => 'bar'
    );
    
    $vf = new VirtualForm();
    echo $vf->createLink(
      $post,'Submit!!',basename(__FILE__),'POST','_self',
      'color:red;text-decoration:green;','color:black;background:white;'
    );
    
実行結果

    <script type="text/javascript">
    <!--
    document.write('<a href="" onClick="document.postForm_0.submit();return false;" style="color:red;text-decoration:green;">Submit!!</a>\n');
    document.write('<form name="postForm_0" method="POST" action="test.php">\n');
    document.write('<input type="hidden" name="tokens[access_token]" value="&amp;&amp;&amp;" />\n');
    document.write('<input type="hidden" name="tokens[access_token_secret]" value="pass" />\n');
    document.write('<input type="hidden" name="foo" value="bar" />\n');
    document.write('</form>\n');
    //-->
    </script>
    <noscript>
    <form method="POST" action="test.php">
    <input type="hidden" name="tokens[access_token]" value="&amp;&amp;&amp;">
    <input type="hidden" name="tokens[access_token_secret]" value="pass">
    <input type="hidden" name="foo" value="bar">
    <input type="submit" value="Submit!!" style="color:black;background:white;">
    </form>
    </noscript>

[EasyCrypt]: https://github.com/Certainist/To_aru_Library/blob/master/EasyCrypt.php
[array_slide]: https://github.com/Certainist/To_aru_Library/blob/master/array_slide.php
[VirtualForm]: https://github.com/Certainist/To_aru_Library/blob/master/VirtualForm.php