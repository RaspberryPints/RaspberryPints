<?php
/***************************************************************************
*                             sql_parse.php
*                              -------------------
*     begin                : Thu May 31, 2001
*     copyright            : (C) 2001 The phpBB Group
*     email                : support@phpbb.com
*
*     $Id: sql_parse.php,v 1.8 2002/03/18 23:53:12 psotfx Exp $
*
****************************************************************************/

/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
***************************************************************************/

/***************************************************************************
*
*   These functions are mainly for use in the db_utilities under the admin
*   however in order to make these functions available elsewhere, specifically
*   in the installation phase of phpBB I have seperated out a couple of
*   functions into this file.  JLH
*
\***************************************************************************/
const DELIMITER = "delimiter";
//
// remove_comments will strip the sql comment lines out of an uploaded sql file
// specifically for mssql and postgres type files in the install....
//
function remove_comments(&$output)
{
$lines = explode("\n", $output);
$output = "";

// try to keep mem. use down
$linecount = count($lines);

$in_comment = false;
for($i = 0; $i < $linecount; $i++)
{
	$startPos = strpos($lines[$i], "/*");
	$endPos = strpos($lines[$i], "*/");
	if($endPos !== false)$endPos+=2;
	$len = strlen($lines[$i]);
	$line = "";
	
	//Have a start /* but no end in this line
	if($startPos !== false && $endPos == false)
	{
		$in_comment = true;
		$line = substr($lines[$i], 0, $startPos);
	} 
	//Previous line did not have a /*
	else if( !$in_comment )
	{
		// Line contains /* take everything infront of it
		if ( $startPos > 0 )
		{
			$line = substr($lines[$i], 0, $startPos);	
		}
		//No comment at all
		else if( $startPos !== 0 )
		{
			$line = $lines[$i];
		}
	}
	//check if there */ in line and if there is anything after it
	if( $endPos !== false && $endPos < $len )$line .= substr($lines[$i], $endPos, $len);
	if(rtrim($line) != "") $output .= $line . "\n";
	
	//echo '['.$lines[$i].']['.$line.']['.$startPos.']['.$endPos.']['.$len.']'."<br>";
	
	if( $endPos !== false )
	{
		$in_comment = false;
	}
}

unset($lines);
return $output;
}

//
// remove_remarks will strip the sql comment lines out of an uploaded sql file
//
function remove_remarks($sql)
{
$lines = explode("\n", $sql);

// try to keep mem. use down
$sql = "";

$linecount = count($lines);
$output = "";

for ($i = 0; $i < $linecount; $i++)
{
	if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0))
	{
		$line = "";
		if (isset($lines[$i][0]) && $lines[$i][0] != "#")
		{
		    $startPos = strpos($lines[$i], "--");
		    //check and see if the -- is in a string, if so skip it
		    if( $startPos !== false )
		    {
		        while( (substr_count ($lines[$i], "'", 0, $startPos )%2 != 0) && ($startPos = strpos($lines[$i], "--", $startPos+1)) !== false);
		    }
			if( $startPos !== false )
			{
			    $line = substr($lines[$i], 0, $startPos);
			}
			else
			{				
				$line = $lines[$i];
			}
		}
		//echo '['.$lines[$i].']['.$line.']['.$startPos.']'."<br>";
		$output .= $line."\n";
		
		// Trading a bit of speed for lower mem. use here.
		$lines[$i] = "";
	}
}

return $output;

}

//
// split_sql_file will split an uploaded sql file into single sql statements.
// Note: expects trim() to have already been run on $sql.
//
function split_sql_file($sql, $delimiter)
{
// Split up our string into "possible" SQL statements.
$tokens = explode($delimiter, $sql);

// try to save mem.
$sql = "";
$output = array();

// we don't actually care about the matches preg gives us.
$matches = array();

// this is faster than calling count($oktens) every time thru the loop.
$token_count = count($tokens);
for ($i = 0; $i < $token_count; $i++)
{
	// Don't wanna add an empty string as the last thing in the array.
	if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
	{
	    $tokens[$i] = ltrim($tokens[$i]);
	    //Delimiter command doesnt end with the split delimiter instead it creates a new delimiter
	    $containsDelimiter = strpos(strtolower($tokens[$i]), DELIMITER);
	    if( $containsDelimiter !== FALSE && $containsDelimiter == 0){
	        $tokens_temp = preg_split('/\r\n|\r|\n/', $tokens[$i]);
	        //Split DELIMITER ?? into DELIMITER, [ ]?? (incase there are multiple spaces between the comannd and arg)
	        //Dont save DELIMITER as mysqli->query doesnt need it
	        $newDelimiter = ltrim(explode(' ', $tokens_temp[0], 2)[1]);
	        $tokens[$i] = '';
	        for($j = 1; $j < count($tokens_temp); $j++) $tokens[$i] .= $tokens_temp[$j];
	        if($tokens[$i] == '') $i++;
	        for(;$i < $token_count; $i++) {
	            if(strpos($tokens[$i], $newDelimiter) === FALSE){
	                $tokens[$i+1] = $tokens[$i].$delimiter.$tokens[$i+1];
	            } else {
	                $tokens_temp = explode($newDelimiter, $tokens[$i]);
	                $tokens[$i] = $tokens_temp[0];
	                break;
	            }
	        }
	    }
		// This is the total number of single quotes in the token.
		$total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
		// Counts single quotes that are preceded by an odd number of backslashes,
		// which means they're escaped quotes.
		$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);

		$unescaped_quotes = $total_quotes - $escaped_quotes;

		// If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
		if (($unescaped_quotes % 2) == 0)
		{
			// It's a complete sql statement.
			$output[] = $tokens[$i];
			// save memory.
			$tokens[$i] = "";
		}
		else
		{
			// incomplete sql statement. keep adding tokens until we have a complete one.
			// $temp will hold what we have so far.
			$temp = $tokens[$i] . $delimiter;
			// save memory..
			$tokens[$i] = "";

			// Do we have a complete statement yet?
			$complete_stmt = false;

			for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
			{
			// This is the total number of single quotes in the token.
			$total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
			// Counts single quotes that are preceded by an odd number of backslashes,
			// which means they're escaped quotes.
			$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);

			$unescaped_quotes = $total_quotes - $escaped_quotes;

			if (($unescaped_quotes % 2) == 1)
			{
				// odd number of unescaped quotes. In combination with the previous incomplete
				// statement(s), we now have a complete statement. (2 odds always make an even)
				$output[] = $temp . $tokens[$j];

				// save memory.
				$tokens[$j] = "";
				$temp = "";

				// exit the loop.
				$complete_stmt = true;
				// make sure the outer loop continues at the right point.
				$i = $j;
			}
			else
			{
				// even number of unescaped quotes. We still don't have a complete statement.
				// (1 odd and 1 even always make an odd)
				$temp .= $tokens[$j] . $delimiter;
				// save memory.
				$tokens[$j] = "";
			}

			} // for..
		} // else
	}
}

return $output;
}
?>