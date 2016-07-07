<?php 
	
	function escape_chars($text, $chars=null) {
		$chars = (is_null($chars)) ? array("'") : $chars;
		foreach ($chars as $key => $char) {
			$text = preg_replace('/'.$char.'/im', '\\'.$char, $text);
		}
		return $text;
	}

?>