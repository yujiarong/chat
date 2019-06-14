<?php
namespace App\Services;
use GuzzleHttp\Client;
/**
 * 第三方登陆服务
 */
class AIChatService extends BaseService
{

	/**
	 * 非法调用第三方接口  哈哈
	 */	
	public function IAChat($content){
		$url  = 'http://i.xiaoi.com/robot/webrobot';
		$data = json_encode([ "body"=>["content"=>$content],"type"=>"txt" ]);
		$url  = $url.'?data='.$data;
		$client = new Client([
		    'base_uri' => $url,
		    'timeout'  => 10.0,
		]);
		$response = $client->get($url);
		$body     = $response->getBody();
		$data     = $body->getContents();
		$pattern = '/content":"(.+)","/iU';
		$data = preg_match_all($pattern, $data,$matches);
		if(empty($matches[0])){
			return '小I同学 解析失败';
		}else{
			return str_replace('\r\n',".",$matches[1][1]);
		}
	}
}
