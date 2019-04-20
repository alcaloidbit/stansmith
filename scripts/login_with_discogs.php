<?php
/*
 * mysqli_login_with_google.php
 *
 * @(#) $Id: mysqli_login_with_google.php,v 1.2 2013/07/31 11:48:04 mlemos Exp $
 *
 */

    /*
     *  Get the http.php file from http://www.phpclasses.org/httpclient
     */

    include dirname(__FILE__).'/config/config.inc.php';

    /*
     * Create an object of the sub-class of the OAuth client class that is
     * specialized in storing and retrieving access tokens from MySQL
     * databases using the mysqli extension
     *
     * If you use a different database, replace this class by another
     * specialized in accessing that type of database
     */
    $client = new PDO_oauth_client_class;
    // $client->user = 1;
    // $client->user = 1;

    $client->server = 'Discogs';

    /*
     * Set the offline access only if you need to call an API
     * when the user is not present and the token may expire
     */
    // $client->offline = true;

    $client->debug = true;
    $client->debug_http = true;
    $client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
        dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/login_with_discogs.php';

    $client->client_id = 'gNwlyicdEBfdEVTDibaF'; $application_line = __LINE__;
    $client->client_secret = 'SQWvqMdbmBAFVSDXCRNrfkJgNTHgadCZ';


    if(strlen($client->client_id) == 0
    || strlen($client->client_secret) == 0)
        die('Please go to Discogs Developers page http://www.discogs.com/applications/edit , '.
            'create an application, and in the line '.$application_line.
            ' set the client_id to Consumer key and client_secret with Consumer secret. '.
            'The Callback URL must be '.$client->redirect_uri);

    if(($success = $client->Initialize()))
    {
        if(($success = $client->Process()))
        {
            if( strlen($client->authorization_error) )
            {
                $client->error = $client->authorization_error;
                $success = false;
            }
            elseif(strlen($client->access_token))
            {
                $success = $client->CallAPI(
                    'http://api.discogs.com/oauth/identity',
                    'GET', array(), array('FailOnAccessError'=>true), $user);

                /*
                 * Once you were able to access the user account using the API
                 * you should associate the current OAuth access token a specific
                 * user, so you can call the API without the user presence, just
                 * specifying the user id in your database.
                 *
                 * In this example the user id is 1 . Your application should
                 * determine the right user is to associate.
                 */
                if($success)
                    $success = $client->SetUser(1);
            }
        }
        $success = $client->Finalize($success);
    }
    if($client->exit)
        exit;
    if($success)
    {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Google OAuth client results</title>
</head>
<body>
<?php
        echo '<h1>', HtmlSpecialChars($user->username),
            ' you have logged in successfully with Google!</h1>';
        echo '<pre>', HtmlSpecialChars(print_r($user, 1)), '</pre>';
?>
</body>
</html>
<?php
    }
    else
    {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>OAuth client error</title>
</head>
<body>
<h1>OAuth client error</h1>
<pre>Error: <?php echo HtmlSpecialChars($client->error); ?></pre>
</body>
</html>
<?php
    }

?>
