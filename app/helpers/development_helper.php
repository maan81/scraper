<?php


/**
 *  php's print_r's customization
 *
 *  @param array -- data to be printed
 *  @param bool  -- to end after the printing
 *  @param bool  -- to return as string
 *  @return string/die
 */
if ( ! function_exists('element')){

	function _print_r($data,$end=true,$return=false){

		$str = '';

		if(!$return){

			$t = debug_backtrace();

			$str .= '<hr/>';
			$str .= '<pre>';
			$str .= print_r('file : '.$t[0]['file'],true);
			$str .= '</pre>';
			$str .= '<pre>';
			$str .= print_r('line : '.$t[0]['line'],true);
			$str .= '</pre>';
			$str .= '<pre>';
			$str .= print_r('data :'.print_r($data,true),true);
			$str .= '</pre>';
			$str .= '<hr/>';
		}


		if(!$end){
			echo $str;
			return;
		}

		echo $str;
		die;
	}
}