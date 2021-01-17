<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Management.php
 *
 * @author: aida
 * @version: 2019-03-16 14:11:21
 */
 

class Management {

	public function __construct( $params = array() ) {

	}

	/**
	 * @param array $params
	 * @return array
	 */
	function setDefault( $params ) {

		$data = array();

		if ( isset($params["start_year"]) ) {
			if ( $params["start_year"] != FALSE ) {
				$start_year = $params["start_year"];
			} else {
				$start_year = date( "Y" );
			}
			$data['start_year'] = $start_year;
		}

		if ( isset($params["start_month"]) ) {
			if ( $params["start_month"] != FALSE ) {
				$start_month = $params["start_month"];
			} else {
				$start_month = date( "m" );
			}
			$data['start_month'] = $start_month;
		}

		if ( isset($params["start_day"]) ) {
			if ( $params["start_day"] != FALSE ) {
				$start_day = $params["start_day"];
			} else {
				$start_day = date( "d" );
			}
			$data['start_day'] = $start_day;
		}

		if ( isset($params["start_hour"]) ) {
			if ( $params["start_hour"] != FALSE ) {
				$start_hour = $params["start_hour"];
			} else {
				$start_hour = 0;
			}
			$data['start_hour'] = $start_hour;
		}

		if ( isset($params["start_minute"]) ) {
			if ( $params["start_minute"] != FALSE ) {
				$start_minute = $params["start_minute"];
			} else {
				$start_minute = 0;
			}
			$data['start_minute'] = $start_minute;
		}

		if ( isset($params["end_year"]) ) {
			if ( $params["end_year"] != FALSE ) {
				$end_year = $params["end_year"];
			} else {
				$end_year = date( "Y" );
			}
			$data['end_year'] = $end_year;
		}

		if ( isset($params["end_month"]) ) {
			if ( $params["end_month"] != FALSE ) {
				$end_month = $params["end_month"];
			} else {
				$end_month = date( "m" );
			}
			$data['end_month'] = $end_month;
		}

		if ( isset($params["end_day"]) ) {
			if ( $params["end_day"] != FALSE ) {
				$end_day = $params["end_day"];
			} else {
				$end_day = date( "d" );
			}
			$data['end_day'] = $end_day;
		}

		if ( isset($params["end_hour"]) ) {
			if ( $params["end_hour"] != FALSE ) {
				$end_hour = $params["end_hour"];
			} else {
				$end_hour = 23;
			}
			$data['end_hour'] = $end_hour;
		}

		if ( isset($params["end_minute"]) ) {
			if ( $params["end_minute"] != FALSE ) {
				$end_minute = $params["end_minute"];
			} else {
				$end_minute = 59;
			}
			$data['end_minute'] = $end_minute;
		}


		if ( isset($params["year"]) ) {
			if ( $params["year"] != FALSE ) {
				$year = $params["year"];
			} else {
				$year = date( "Y" );
			}
			$data['year'] = $year;
		}

		if ( isset($params["month"]) ) {
			if ( $params["month"] != FALSE ) {
				$month = $params["month"];
			} else {
				$month = date( "m" );
			}
			$data['month'] = $month;
		}

		if ( isset($params["day"]) ) {
			if ( $params["day"] != FALSE ) {
				$day = $params["day"];
			} else {
				$day = date( "d" );
			}
			$data['day'] = $day;
		}

		if ( isset($params["hour"]) ) {
			if ( $params["hour"] != FALSE ) {
				$hour = $params["hour"];
			} else {
				$hour = date( "H" );
			}
			$data['hour'] = $hour;
		}

		if ( isset($params["minute"]) ) {
			if ( $params["minute"] != FALSE ) {
				$minute = $params["minute"];
			} else {
				$minute = date( "i" );
			}
			$data['minute'] = $minute;
		}


		return $data;
	}

	/**
	 * @return array
	 */
	function getYearArray() {

		$formYear = array();
		for ( $i = date( "Y" )-1; $i <= date( "Y" )+3; $i++ ) {
			$formYear[$i] = sprintf( "%d", $i );
		}
		return $formYear;
	}

	/**
	 * @return array
	 */
	function getMonthArray() {
		$formMonth = array();
		for ( $i = 1; $i <= 12; $i++ ) {
			$formMonth[$i] = sprintf( "%d", $i );
		}
		return $formMonth;
	}

	/**
	 * @return array
	 */
	function getDayArray() {
		$formDay = array();
		for ( $i = 1; $i <= 31; $i++ ) {
			$formDay[$i] = sprintf( "%d", $i );
		}
		return $formDay;
	}

	/**
	 * @return array
	 */
	function getHourArray() {
		$formHour = array();
		for ( $i = 0; $i <= 23; $i++ ) {
			$formHour[$i] = sprintf( "%d", $i );
		}
		return $formHour;
	}

	/**
	 * @return array
	 */
	function getMinuteArray() {
		$formMinute = array();
		for ( $i = 0; $i <= 59; $i++ ) {
			$formMinute[$i] = sprintf( "%d", $i );
		}
		return $formMinute;
	}

    /**
     * @param array $config
     * @return array
     */
    function getPageConfig($config = array()){

        $config['use_page_numbers'] = TRUE;
        // 選択中のページ番号の前後に表示したい "数字" リンクの数。
        $config["num_links"] = 4;

        $config['prev_tag_open'] = '<li>';
        $config['prev_link'] = '<span aria-hidden="true">«</span>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_link'] = '<span aria-hidden="true">»</span>';
        $config['next_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a tabindex="-1">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        return $config;

    }

}
