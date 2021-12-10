<?php
$g_dbHostName = "localhost";
$g_dbUserName = "root";
$databaseName="cognifront";
$g_dbPassword = "";

function connect_to_database ($databaseName)
{
	global $g_dbHostName, $g_dbUserName, $g_dbPassword;
	
	$con = null;
	
	/* Let's connect to host		*/
	$con = mysqli_connect ($g_dbHostName, $g_dbUserName, $g_dbPassword, $databaseName);

	// Check connection
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  die ("Failed to connect to MySQL server");
	}

	// set support for Bharat languages and Unicode in general
	// without this the non-english languages will not display correctly
	mysqli_query($con,'SET names=utf8');
	mysqli_query($con,'SET character_set_client=utf8');
	mysqli_query($con,'SET character_set_results=utf8');
	mysqli_query($con,'SET character_set_connection=utf8');
	mysqli_query($con,'SET collation_connection=utf8_general_ci');
	
	return $con;
}



function disconnect_from_database($con)
{		
	mysqli_close($con);
}

function createSSPArray ($dbname)
{
	global $g_dbHostName, $g_dbUserName, $g_dbPassword;

	return array (
	'user' => $g_dbUserName,
	'pass' => $g_dbPassword,
	'db'   => $dbname,
	'host' => $g_dbHostName
	);
}

function cleanInput ($input)
{ 
	$search = array (
		'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
		'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
		'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
		'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
	);

	$output = preg_replace ($search, '', $input);
	return $output;
}

function sanitize ($con, $input)
{
    if (is_array($input))
    {
        foreach ($input as $var=>$val)
            $output[$var] = sanitize ($con, $val);
    }
    else
	{
        if (get_magic_quotes_gpc())
            $input = stripslashes ($input);
        $input  = cleanInput ($input);
        $output = mysqli_real_escape_string ($con, $input);
    }
    return $output;
}

function escape ($input)
{
    if (is_array($input))
    {
        foreach ($input as $var=>$val)
            $output[$var] = escape ($val);
    }
    else
        $output = htmlentities ($input, ENT_QUOTES, 'UTF-8');
    return $output;
}
?>