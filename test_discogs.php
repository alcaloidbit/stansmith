<?php


include dirname(__FILE__).'/config/config.inc.php';


$client = new DiscogsClient();

$json = $client->search('https://api.discogs.com/database/search?artist=Para+one&release_title=Epiphanie');

$res = json_decode($json);



foreach($res->results as $k=>$v)
{

	p($v->style);
	p($v->country);
	p($v->barcode);
	p($v->uri);
	p($v->label);
	p($v->year);
	p($v->genre);
	p($v->title);
	p($v->type);
	p($v->resource_url);
	p($v->id);

echo '<hr />';
}


