<?php
/**
 * WP All Import / Export Pro Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Junaidbhura\Composer\WPProPlugins\Http;

/**
 * WpAiPro class.
 */
class WpAiPro {

	/**
	 * The version number of the plugin to download.
	 *
	 * @var string Version number.
	 */
	protected $version = '';

	/**
	 * The slug of which plugin to download.
	 *
	 * @var string Plugin slug.
	 */
	protected $slug = '';

	/**
	 * WpAiPro constructor.
	 *
	 * @param string $version
	 * @param string $slug
	 */
	public function __construct( $version = '', $slug = 'wp-all-import-pro' ) {
		$this->version = $version;
		$this->slug    = $slug;
	}

	/**
	 * Get the download URL for this plugin.
	 *
	 * @return string
	 */
	public function getDownloadUrl() {
		if ( 'wp-all-export-pro' === $this->slug ) {
			$license = getenv( 'WP_ALL_EXPORT_PRO_KEY' );
			$url     = getenv( 'WP_ALL_EXPORT_PRO_URL' );
			$name    = 'WP All Export';
		} else {
			$license = getenv( 'WP_ALL_IMPORT_PRO_KEY' );
			$url     = getenv( 'WP_ALL_IMPORT_PRO_URL' );

			switch ( $this->slug ) {
				case 'wpai-acf-add-on':
					$name    = 'ACF Add-On';
					$license = '';
					break;
				case 'wpai-linkcloak-add-on':
					$name    = 'Link Cloaking Add-On';
					$license = '';
					break;
				case 'wpai-user-add-on':
					$name    = 'User Import Add-On';
					$license = '';
					break;
				case 'wpai-woocommerce-add-on':
				case 'wpai-woocommerce-add-on-pro':
					$name    = 'WooCommerce Import Add-On Pro';
					$license = '';
					break;
				case 'wpae-woocommerce-add-on':
				case 'wpae-woocommerce-add-on-pro':
					$name    = 'WooCommerce Export Add-On Pro';
					$license = '';
					break;
				case 'wpae-user-add-on':
					$name    = 'User Export Add-On';
					$license = '';
					break;
				default:
					$name = 'WP All Import';
			}
		}

		$http     = new Http();
		$response = json_decode( $http->post( 'https://www.wpallimport.com', array(
			'edd_action' => 'get_version',
			'license'    => $license,
			'item_name'  => $name,
			'url'        => $url,
			'version'    => $this->version,
		) ), true );
		if ( ! empty( $response['download_link'] ) ) {
			return $response['download_link'];
		}
		return '';
	}

}
