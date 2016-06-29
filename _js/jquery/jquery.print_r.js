jQuery.extend({
	print_r:function( obj, dst) {

/* print_r出力 機能追加 */

/**
 * Function print_r( obj, dst)
 *     obj : 出力する変数
 *     dst : 指定なしのとき、結果をdocumentに出力
 *            id名を指定のとき、結果をidで指定されたタグに出力
 *            falseを指定のとき、結果を文字列として返す。
 */

	/**
	 * Function : dump()
	 * Arguments: The data - array,hash(associative array),object
	 *    The level - OPTIONAL
	 * Returns  : The textual representation of the array.
	 * This function was inspired by the print_r function of PHP.
	 * This will accept some data as the argument and return a
	 * text that will be a more readable version of the
	 * array/hash/object that is given.
	 * Docs: http://www.openjs.com/scripts/others/dump_function_php_print_r.php
	 */
	/* Modified by IS Planning */
	function dump(arr,level) {
		var ret = "";
		if(!level) level = 0;
		if(level >= 30) {
			return "Nesting too deep\n";
		}
		
		//The padding given at the beginning of the line.
		var level_padding = "";
		for(var j=0;j<level;j++) level_padding += "    ";

		if(arr == null)	{ //null
			ret = "null\n";
		} else if(typeof(arr) == 'object') { //Array/Hashes/Objects 
			if (arr.constructor == Array) {
				ret += level_padding + "Array\n";
			} else if ( arr.constructor == Object ) {
				ret += level_padding + "Object\n";
			} else {
				ret += level_padding + "Other " + arr.toString() + "\n";
				return ret;
			}
			ret += level_padding + "(\n";
			for(var item in arr) {
				var value = arr[item];
				if(typeof(value) == 'object') { //If it is an array,
					ret += level_padding + "    [" + item + "] =>\n";
					ret += dump(value,level+2);
				} else {
					ret += level_padding + "    [" + item + "] => "
					         + value + "\n";
				}
			}
			ret += level_padding + ")\n";
		} else if(typeof(arr) == 'function') { // function
			ret = arr+"\n";
		} else { //Stings/Chars/Numbers etc.
			ret = arr+"\n";
		}
		return ret;
	}

	/**
	 * Function parseStr( src)
	 *     src : 変換元文字列
	 *     戻り値 : 変換元文字列を htmlエスケープして出力する。
	 */
	function parseStr( src) {
		
		src = src.replace(/&/g, "&amp;");
		src = src.replace(/ /g, "&nbsp;");
		src = src.replace(/</g, "&lt;");
		src = src.replace(/>/g, "&gt;");
		src = src.replace(/\n/g, "<br />");
		
		return src;
	}


	if (typeof(dst) == "undefined")	{
		// 指定なしのとき、結果をdocumentに出力
		$("body").append(parseStr(dump(obj)));
	} else if (typeof(dst) == "string") {
		// id名を指定のとき、指定タグに出力
		 $("#" + dst).append(parseStr(dump(obj)));
	} else if (typeof(dst) == "boolean" && dst == true) {
		// false指定のとき、結果を文字列として返す。
		alert(dump(obj));
	}


}
});
