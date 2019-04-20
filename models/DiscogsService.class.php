
<?php



/// TODO : FIND A WAY TO PROPERLY HANDLE ERRORS ( AUTH )
class DiscogsService
{
	public $client;

	public $errors = array();
	public $infos = array();

	public function __construct()
	{
		$this->client = new PDO_oauth_client_class;
		$this->client->debug = true;
		$this->client->debug_http = true;
		$this->client->server = 'Discogs';
		$this->client->client_id = 'gNwlyicdEBfdEVTDibaF';
		$this->client->client_secret = 'SQWvqMdbmBAFVSDXCRNrfkJgNTHgadCZ';
		$this->client->user = 1;

	}

	/**
	 * Perform a oAuth Signed Search Query
	 * on Discogs Database for artist and release params
	 * @param  string $artist  Artist name
	 * @param  string $release Release title
	 *
	 * @return response array
	 */
	public function search( $artist, $release )
	{
		$scope = 'http://api.discogs.com/database/search';

		if(($success = $this->client->Initialize()))
		{
			$this->client->url_parameters  = true;
			if(( $success = $this->client->Process()))
			{
				p( $this->client->debug_output );
				if( strlen($this->client->authorization_error) )
            	{
            		$this->client->error = $this->client->authorization_error;


                	return false;
            	}
				elseif(strlen($this->client->access_token))
				{
					$this->client->CallAPI( $scope, 'GET', array( 'release_title' => $release, 'artist' => $artist ), array('FailOnAccessError'=>true), $response);
              	}
			}
		    $this->client->Finalize($success); // Close Db Object
		}
		return  $response;
	}


	/**
	 * Using Curl, get Json decoded Results Array about a release
	 * @param  int $id_release
	 * @return  array
	 */
	public function getRelease( $id_release )
	{
		$url = 'http://api.discogs.com/releases/'.$id_release.'';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_USERAGENT,'StanSmithPublicLibrary/1.0 +http://176.31.245.123/stansmith');
		$result=curl_exec($ch);
		curl_close($ch);

		return json_decode($result, true);
	}



	/**
	 * Parse a Release array to return image uri
	 * @param  array  $release release info
	 * @return imguri or false if no images key found
	 */
	public function getImageUriFromRelease( array $release )
	{
		if( isset( $release['images'] ) )
			return $release['images'][0]['resource_url']; // Ici on recupere la premiere image associé au release, ( A VOIR GESTION PLUSIEURS IMAGES )
		else
			return false;
	}


	/**
	 * Perform a Signed Query and get an image resource
	 * @param  string $img_uri the image uri
	 * @return a base64 encoded image string
	 */
	public function getRawImageData( $img_uri )
	{
		if(( $success = $this->client->Initialize() ))
		{
			if(($success = $this->client->Process()))
			{
				if( strlen($this->client->access_token) )
				{
						$success = $this->client->CallAPI(
							$img_uri, 'GET', array(), array(
									 'failOnAccessError' => true ), $response );



					  	if($success)
                    		$success = $this->client->SetUser(1);
				}
			}
			$success = $this->client->Finalize($success);
		}
		$rawimg = base64_encode( $response );
		return $rawimg;
	}

	/**
	 * Get Image dimensions From a base64encoded image
	 * @param  str base64 encoded image
	 * @return array the image dimension array(width => '', height => '')
	 */
	public function getImageDimension( $rawimg )
	{
		$dim = getimagesizefromstring( base64_decode( $rawimg ));
		$dimension['width']  = $dim[0];
		$dimension['height'] = $dim[1];
		return $dimension;
	}

}