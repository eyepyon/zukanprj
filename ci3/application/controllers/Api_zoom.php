<?php
use GuzzleHttp\Client;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Builder;

/**
 *  Api_zoom
 *
 * @author: aida
 * @version 2021/06/24 22:00
 *
 * @property Zoom_model $zoomModel
 * @property Mmapi $Mmapi
 */
class Api_zoom extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library('Mmapi');
		$this->load->model('Zoom_model', 'zoomModel');

		$this->data['base_url'] = $this->config->item('base_url');
	}

	public function index(){


	}

	/**
	 * @return mixed
	 */
	private function createJwtToken()
	{
		$api_key = 'z4CzA2KoS8uULvqsKvrYHg';
		$api_secret = 'IFsIoaR1GrI3NqsKgmikgj9ifs0tyhhbIfhF';
		$signer = new Sha256;
		$key = new Key($api_secret);
		$time = time();
		$jwt_token = (new Builder())->setIssuer($api_key)
			->expiresAt($time + 3600)
			->sign($signer, $key)
			->getToken();
		return $jwt_token;
	}

	/**
	 * @return mixed
	 */
	private function fetchUserId()
	{
		$method = 'GET';
		$path = 'users';
		$client_params = [
			'base_uri' => $this->data['base_url'],
		];
		$result = $this->sendRequest($method, $path, $client_params);
		$user_id = $result['users'][0]['id'];
		return $user_id;
	}

	/**
	 * @return mixed
	 */
	public function createMeeting()
	{
		$user_id = $this->fetchUserId();
		$params = [
			'topic' => 'テスト',
			'type' => 1,
			'time_zone' => 'Asia/Tokyo',
			'agenda' => 'ズームAPIを試す',
			'settings' => [
				'host_video' => true,
				'participant_video' => true,
				'approval_type' => 0,
				'audio' => 'both',
				'enforce_login' => false,
				'waiting_room' => false,
			]
		];
		$method = 'POST';
		$path = 'users/'. $user_id .'/meetings';
		$client_params = [
			'base_uri' => $this->data['base_url'],
			'json' => $params
		];
		$result = $this->sendRequest($method, $path, $client_params);
		return $result;
	}

	/**
	 * @param $method
	 * @param $path
	 * @param $client_params
	 * @return mixed
	 */
	private function sendRequest($method, $path, $client_params)
	{
		$client = new Client($client_params);
		$jwt_token = $this->createJwtToken();
		$response = $client->request($method,
			$path,
			[
				'headers' => [
					'Content-Type' => 'application/json',
					'Authorization' => 'Bearer ' . $jwt_token,
				]
			]);
		$result_json = $response->getBody()->getContents();
		$result = json_decode($result_json, true);
		return $result;
	}
}

