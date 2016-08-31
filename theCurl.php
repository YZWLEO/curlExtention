<?php


/**
 * Created by PhpStorm.
 * User: Leo.Yan
 * Date: 2016
 * Time: 12:13
 * Version:2.0
 * Project:curlExtention
 * File: theCurl.php
 */

namespace plug_curl\theCurl;

class theCurl
{
	/**
	 * 发送一个http请求
	 * @param  $url    请求链接
	 * @param  $method 请求方式
	 * @param array $vars 请求参数
	 * @param  $time_out  请求过期时间
	 * @return JsonObj
	 */
	static function get_curl($url, array $vars = array(), $method = 'post')
	{
		$method = strtolower($method);
		if ($method == 'get' && !empty($vars)) {
			if (strpos($url, '?') === false)
				$url = $url . '?' . http_build_query($vars);
			else
				$url = $url . '&' . http_build_query($vars);
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		if ($method == 'post') {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		}
		$result = curl_exec($ch);
		if (!curl_errno($ch)) {
			$result = trim($result);
		} else {
			$result = '[error：1]';
		}

		curl_close($ch);
		return $result;

	}

	/**
	 * 获取客户端ip
	 * */
	static function getIp()
	{
		if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP'];
		} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if (isset($_SERVER['REMOTE_ADDR'])) {
			return $_SERVER['REMOTE_ADDR'];
		}
		return '0.0.0';
	}
}