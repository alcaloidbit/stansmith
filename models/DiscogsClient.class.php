<?php


class DiscogsClient
{
	private $user_agent;
	private $key;
	private $secret;
	public function __construct()
	{
		$this->user_agent  = 'StansmithPrivateProject /1.0 +http://176.31.245.123/stansmith';
		$this->key = 'TOaCSXoMrpZVkUIYlvxG';
		$this->secret = 'kFKbBfQdbIPdzlwiiAIghhcjyJFOyymA';
	}

	public function makeRequest($url)
	{
		if(isset($url))
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent );
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt( $ch, CURLOPT_ENCODING, 'gzip');

			$buffer = curl_exec($ch);
			curl_close($ch);

			if($buffer)	return $buffer;
				else throw new Exception('Discogs API connection error.');

		}else throw new Exception('Discogs EndPoint Not Set.');

	}

	public function search($url)
	{
		$url .= '&key='.$this->key.'&secret='.$this->secret.'';
		return $this->makeRequest($url);
	}

	public function getRelease($release_id)
	{
		$url = 'https://api.discogs.com/releases/'.$release_id;
		return  $this->makeRequest($url);
	}
}