<?php
class Checkpvchange extends Application {
	function __construct() {
		parent::__construct ();
	}
	function index() {
		$liveindexes = $this->db->getResult ( "SELECT distinct(ticker)  FROM tbl_indxx_ticker WHERE status='1' union SELECT distinct(ticker)  FROM tbl_indxx_ticker_temp WHERE status='1' ", true );
		// $this->pr($liveindexes,true);
		
		$indxxvaluesarray = array ();
		
		if (! empty ( $liveindexes )) {
			foreach ( $liveindexes as $key => $value ) {
				
				$indxxvaluesarray [$key] = $value;
				
				$liveindexvalues = $this->db->getResult ( "SELECT  date,price , isin,curr from tbl_prices_local_curr where ticker='" . $value ['ticker'] . "'order by date desc limit 0,2", true );
				$indxxvaluesarray [$key] ['values'] = $liveindexvalues;
			}
		}
		
		// $this->pr($indxxvaluesarray,true);
		$str = '';
		if (! empty ( $indxxvaluesarray )) {
			foreach ( $indxxvaluesarray as $indxx ) { // echo $indxx['values'];
				
				if (count ( $indxx ['values'] ) == 2) {
					
					// $this->pr($indxx);
					$value1 = $indxx ['values'] [0] ['price'];
					$value2 = $indxx ['values'] [1] ['price'];
					$diff = 100 * (($value1 - $value2) / $value2);
					// echo $indxx['code']."=>".$diff;
					// echo "<br>";
					
					if ($diff >= 5 || $diff <= - 5) {
						$str .= $indxx ['ticker'] . "(" . $indxx ['values'] [0] ['isin'] . ") -" . $indxx ['values'] [0] ['curr'] . " " . $diff . "%<br/>";
					}
				}
			}
		}
		// exit;
		if ($str) {
			
			$emailQueries = 'select email from tbl_ca_user where status="1" and type!="1" ';
			$email_res = mysql_query ( $emailQueries );
			if (mysql_num_rows ( $email_res ) > 0) {
				
				while ( $email = mysql_fetch_assoc ( $email_res ) ) {
					$emailsids [] = $email ['email'];
				}
			}
			
			if (! empty ( $emailsids )) {
				$emailsids = implode ( ',', $emailsids );
				
				// $emailsids.=',dbajpai@indxx.com';
				
				$msg = 'Hi <br>
			Local Price Change Notification <br/>
			' . $str . " <br>Thanks <br>";
				
				// To send HTML mail, the Content-type header must be set
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Additional headers
				// $headers .= 'To: '.$dbuser['name'].' <'.$dbuser['email'].'>'. "\r\n";
				$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n" . "CC: indexing@indxx.com" . "\r\n";
				// echo $emailsids;
				if (mail ( $emailsids, "Softlayer - Price Change Notification", $msg, $headers )) {
					echo "Mail Send ";
					
					// echo "Mail sent to : ".$dbuser['name']."<br>";
				} else {
					echo "Mail not sent";
				}
			}
		}
		
		$this->saveProcess ( 2 );
		$this->Redirect2 ( "index.php?module=calcweight", "", "" );
	}
}
?>