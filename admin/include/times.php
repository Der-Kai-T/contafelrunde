<?php
 
// Zeit in UNIX-Timestamp
	function TimeToUnix($input){
		@list ($date, $time)      = explode(' ', $input, 2);
		@list ($day, $mon, $year) = explode('.', $date);   
		
		$timestamp = strtotime("$year-$mon-$day $time");
		
		return $timestamp;
	}

	function FormTimeToUnix($input){
				
		$timestamp = strtotime("$input");
		
		return $timestamp;
	}
	
	
// UNIX-Timestamp in dd.mm.yyyy hh:mm:ss
	function UnixToTime($input){
		$datum  = date("d.m.Y", $input);
		$zeit   = date("H:i:s", $input);
		
		$timestring = "$datum $zeit";
				
		return $timestring;
	}	

	function UnixToTime_nosec($input){
		$datum  = date("d.m.Y", $input);
		$zeit   = date("H:i", $input);
		
		$timestring = "$datum $zeit";
				
		return $timestring;
	}	
	
 

	function UnixToDayName($input){
		setlocale(LC_ALL, "de_DE.utf8");
		$datum  = date("w", $input);
		
		
		$tag[0] = "Sonntag";
		$tag[1] = "Montag";
		$tag[2] = "Dienstag";
		$tag[3] = "Mittwoch";
		$tag[4] = "Donnerstag";
		$tag[5] = "Freitag";
		$tag[6] = "Samstag";
		
		$tag_string = $tag[$datum];
		
		$timestring = "$tag_string";
				
		return $timestring;
	}

	function DayNumberToDayName($input){
		$tag[0] = "Sonntag";
		$tag[1] = "Montag";
		$tag[2] = "Dienstag";
		$tag[3] = "Mittwoch";
		$tag[4] = "Donnerstag";
		$tag[5] = "Freitag";
		$tag[6] = "Samstag";

		return $tag[$input];
	}



	
	
	function UnixToFileTime($input){
		$datum  = date("Y.m.d", $input);
		$zeit   = date("H.i.s", $input);
		
		$timestring = "$datum.$zeit";
				
		return $timestring;
	}	
// UNIX-Timestamp in  hh:mm
	function UnixToClock($input){
		$zeit   = date("H:i", $input);
		$timestring = "$zeit";
		return $timestring;
	}	
		
// UNIX-Timestamp in dd.mm.yyyy
	function UnixToDate($input){
		$datum  = date("d.m.Y", $input);
			
		$timestring = "$datum";
				
		return $timestring;
	}	
// UNIX-Timestamp in YYYY
	function UnixToYear($input){
		$Jahr = date("Y", $input);

		
		return $Jahr;
	}	
// UNIX-Timestamp in DD
	function UnixToDay($input){
		$Jahr = date("d", $input);

		
		return $Jahr;
	}	
// UNIX-Timestamp in mm.yyyy
	function UnixToMonth($input){
		$datum  = date("m", $input);
			
		$timestring = "$datum";
				
		return $timestring;
	}	

	//converts Seconds since Midnight to time
	function SecsToTime($input){
		$minutes	= $input/60;
		$hours 		= floor($minutes/60);
		$minutes	= $minutes - ($hours * 60);

		if($minutes<10){
			$minutes = "0".$minutes;
		}
		
		if($hours<10){
			$hours = "0".$hours;
		}
		$return		= $hours.":".$minutes;

		return $return;
	}

	function UnixToToday($input){
		$month[1] = "Januar";
		$month[2] = "Februar";
		$month[3] = "März";
		$month[4] = "April";
		$month[5] = "Mai";
		$month[6] = "Juni";
		$month[7] = "Juli";
		$month[8] = "August";
		$month[9] = "September";
		$month[10] = "Oktober";
		$month[11] = "November";
		$month[12] = "Dezember";
		

		$day = date("d", $input);
		$year = date("Y", $input);
		$mont = date("m", $input);
		$mont = intval($mont);

		$mont_ = $month[$mont];

		return $day.". ".$mont_." ".$year;
		
		
	}

	// Unix Timestamp to confusing american date-format
function UnixToDateEN($input){
	$datum  = date("m/d/Y", $input);
		
	$timestring = "$datum";
			
	return $timestring;
}	
// UNIX-Timestamp to format used for input type="date" fields
function UnixToDateForm($input){
	$datum  = date("Y-m-d", $input);
		
	$timestring = "$datum";
			
	return $timestring;
}	



/*
Format Beschreibung                          Beispiel
  ========================================================
  d      Tag des Monats, zweistellig           03, 28
  j      Tag des Monats                        7, 13
  m      Nummer des Monats, zweistellig        01, 11
  n      Nummer des Monats                     2, 10
  y      Jahr zweistellig                      99, 00
  Y      Jahr vierstellig                      1999, 2001
  H      Stunde im 24-Stunden-Format, zweist.  08, 16
  G      Stunde im 24-Stunden-Format           7, 18
  i      Minuten, zweistellig                  08, 45
  s      Sekunden, zweistellig                 06, 56

  w      Wochentag in Zahlenwert               2, 6
*/
?>