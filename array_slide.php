<?php

//************************************************************
//***************** arary_slide Version 2.3 ******************
//************************************************************
//
//                                           作者: @To_aru_User
//
// ******  概　要  ******
// 
// bool array_slide(
//    array &$array,
//    mixed $key,
//    int $amount
//    [, bool $search_target_with_order = false]
// )
// 
// 第1引数に指定した配列の、第2引数に指定したキーの要素を、
// 第3引数に指定した分だけずらします。
// キーは保存されます。
// 成功した場合はTrue、失敗した場合はFalseを返します。
// 存在する領域を超えてずらそうとすると自動的に補正されます。
// 第4引数の「search target with order」オプションをTrueに設定した場合、
// 第2引数に指定された値で「キー」に関係なく「番目」をもとに検索します。
// 一応、配列の代わりにオブジェクトを入れても動作します。
//

function array_slide(&$array,$key,$amount,$search_target_with_order=false) {
	
	if (!is_array($array) && !is_object($array))
		return false;
	$cnt = 0;
	$parent = array();
	foreach ($array as $_key => $value) {
		if ($search_target_with_order && $key==$cnt ||
		   !$search_target_with_order && $key==$_key) {
				$target = array($_key=>$value);
				$pos = $cnt;
		   }
		$parent[] = array($_key=>$value);
		$cnt++;
	}
	if (!isset($target))
		return false;
	$new_pos = $pos + $amount;
	if ($new_pos < 0)
		$new_pos = 0;
	elseif ($new_pos >= $cnt)
		$new_pos = $cnt - 1;
	$amount = $new_pos - $pos;
	if ($amount===0) {
		return true;
	} elseif ($amount>0) {
		array_splice($parent,$pos,1);
		array_splice($parent,$new_pos,0,array($target));
	} else {
		array_splice($parent,$new_pos,0,array($target));
		array_splice($parent,$pos+1,1);
	}
	$objconv = is_object($array);
	$new_arr = array();
	foreach ($parent as $child)
		foreach ($child as $_key => $value)
			$new_arr[$_key] = $value;
	$array = $new_arr;
	if ($objconv)
		$array = (object)$array;
	return true;
	
}