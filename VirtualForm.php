<?php

//************************************************************
//***************** VirtualForm Version 3.0 ******************
//************************************************************
//
// ******  概　要  ******
// 
// 第1引数のみ必須
// 
// ($vfはクラスのインスタンス)
// bool $vf->createLink(
//    array $data,
//      ⇒http_build_queryに渡す形式の配列
//    [ string $caption     = 'submit', ]
//      ⇒aでくくる文字列
//    [ string $action      = '',       ]
//      ⇒formのaction属性の値
//    [ string $method      = 'POST',   ]
//      ⇒formのmethod属性の値
//    [ string $target      = '_self',  ]
//      ⇒aのtarget属性の値
//    [ string $linkStyle   = '',       ]
//      ⇒aのstyle属性の値
//    [ string $buttonStyle = '',       ]
//      ⇒noscript時のボタンのstyle属性の値
// )
// 
// 簡単にaタグでPOSTが出来るリンクを張れます。
// 多次元配列に対応しています。
// JavaScriptが使えない場合はSubmitボタンで表示します。
//「postForm_0」「postForm_1」「postForm_2」…という風にフォームに名前をつけていくので、
// これらと重複するフォームを作らないように注意してください。
//

class VirtualForm {
	
	private $formCnt;
	
	public function __construct() {
		$this->formCnt = 0;
	}
	
	public function createLink($data,$caption='submit',$action='',$method='POST',$target='_self',$linkStyle='',$buttonStyle='') {
		if (!is_array($data))
			return '';
		if ($linkStyle  !=='')
			$linkStyle   = sprintf(' style="%s"',$linkStyle);
		if ($buttonStyle!=='')
			$buttonStyle = sprintf(' style="%s"',$buttonStyle);
		if (strcasecmp($target,'_self'))
			$target = sprintf(' target="%s"',$target);
		else
			$target = '';
		$a = array(&$caption,&$action,&$method,&$target,&$linkStyle,&$buttonStyle);
		foreach ($a as &$i)
			$i = htmlspecialchars($i,ENT_QUOTES);
		unset($a);
		unset($i);
		$parsed = $this->parse($data);
		$text = '';
		$text .= '<script type="text/javascript">'.PHP_EOL;
		$text .= '<!--'.PHP_EOL;
		$text .= sprintf('document.write(\'<a href="" onClick="document.postForm_%s.submit();return false;"%s%s>%s</a>\\n\');'.PHP_EOL,
				$this->formCnt,$target,$linkStyle,$caption);
		$text .= sprintf('document.write(\'<form name="postForm_%s" method="POST" action="%s">\\n\');'.PHP_EOL,
				$this->formCnt,$action);
		foreach ($parsed as $key => $value)
			$text .= sprintf('document.write(\'<input name="%s" type="hidden" value="%s" />\\n\');'.PHP_EOL,$key,$value);
		$text .= 'document.write(\'</form>\\n\');'.PHP_EOL;
		$text .= '//-->'.PHP_EOL;
		$text .= '</script>'.PHP_EOL;
		$text .= '<noscript>'.PHP_EOL;
		$text .= sprintf('<form method="%s" action="%s">'.PHP_EOL,$method,$action);
		foreach ($parsed as $key => $value)
			$text .= sprintf('<input name="%s" type="hidden" value="%s">'.PHP_EOL,$key,$value);
		$text .= sprintf('<input type="submit" value="%s"%s>'.PHP_EOL,$caption,$buttonStyle);
		$text .= '</form>'.PHP_EOL;
		$text .= '</noscript>'.PHP_EOL;
		$this->formCnt++;
		return $text;
	}
	
	private function parse($data) {
		$query = http_build_query($data,'','&',PHP_QUERY_RFC3986);
		$pairs = explode('&',$query);
		$ret = array();
		foreach ($pairs as $item) {
			$items = explode('=',$item);
			$ret[htmlspecialchars(rawurldecode($items[0]),ENT_QUOTES)] = htmlspecialchars(rawurldecode($items[1]),ENT_QUOTES);
		}
		return $ret;
	}

}