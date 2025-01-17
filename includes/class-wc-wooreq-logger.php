<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Logging class
 *
 * @since 0.1.0
 * @version 0.1.0
 */
class WC_WooReq_Logger {

	public static $logger;
	const WC_LOG_FILENAME = 'woocommerce-gateway-wooreq';

	/**
	 * Used for logging messages to the log
	 *
	 * @since 0.1.0
	 * @version 0.1.0
	 */
	public static function log( $message, $start_time = null, $end_time = null ) {
		if ( empty( self::$logger ) ) {
			self::$logger = new WC_Logger();
		}

		$settings = get_option( 'woocommerce_wooreq_settings' );

		if ( empty( $settings ) || isset( $settings['logging'] ) && 'yes' !== $settings['logging'] ) {
			return;
		}

		if ( ! is_null( $start_time ) ) {

			$formatted_start_time = date_i18n( get_option( 'date_format' ) . ' g:ia', $start_time );
			$end_time             = is_null( $end_time ) ? current_time( 'timestamp' ) : $end_time;
			$formatted_end_time   = date_i18n( get_option( 'date_format' ) . ' g:ia', $end_time );
			$elapsed_time         = round( abs( $end_time - $start_time ) / 60, 2 );

			$log_entry  = '====Start Log ' . $formatted_start_time . '====' . "\n" . $message . "\n";
			$log_entry .= '====End Log ' . $formatted_end_time . ' (' . $elapsed_time . ')====' . "\n\n";

		} else {

			$log_entry = '====Start Log====' . "\n" . $message . "\n" . '====End Log====' . "\n\n";

		}

		self::$logger->add( self::WC_LOG_FILENAME, $log_entry );
	}
}
