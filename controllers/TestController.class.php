<?php


class TestController extends Controller
{
	public function  __construct()
	{
        }
        
        public function display()
	{
	}


	public function test()
	{
	    $id_song = $this->request->getValue('id_song');
            $song = new Song($id_song);
            // d($song);
            $audioinfo = new AudioInfo();
            d($audioinfo->Info($song->path));
	}

	public function ajax()
        {
        }
	public function detail()
	{
	}

}

