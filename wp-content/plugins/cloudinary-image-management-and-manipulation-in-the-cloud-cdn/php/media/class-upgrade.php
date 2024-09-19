<?php
/**
 * Upgrades from a Legecy version of Cloudinary.
 *
 * @package Cloudinary
 */

namespace Cloudinary\Media;

use Cloudinary\Relate;
use Cloudinary\Sync;
use Cloudinary\Utils;

/**
 * Class Filter.
 *
 * Handles filtering of HTML content.
 */
class Upgrade {

	/**
	 * Holds the Media instance.
	 *
	 * @since   0.1
	 *
	 * @var     \Cloudinary\Media Instance of the plugin.
	 */
	private $media;

	/**
	 * Holds the Sync instance.
	 *
	 * @since   0.1
	 *
	 * @var     \Cloudinary\Sync Instance of the plugin.
	 */
	private $sync;

	/**
	 * Filter constructor.
	 *
	 * @param \Cloudinary\Media $media The plugin.
	 */
	public function __construct( \Cloudinary\Media $media ) {
		$this->media = $media;
		$this->sync  = $media->plugin->components['sync'];
		$this->setup_hooks();
	}

	/**
	 * Convert an image post that was created from Cloudinary v1.
	 *
	 * @param int $attachment_id The attachment ID to convert.
	 *
	 * @return string Cloudinary ID
	 */
	public function convert_cloudinary_version( $attachment_id ) {

		if ( ! empty( get_post_meta( $attachment_id, Sync::META_KEYS['cloudinary'], true ) ) ) {
			// V2.5 changed the meta. if it had, theres no upgrades needed.
			/**
			 * Action to trigger an upgrade on a synced asset.
			 *
			 * @hook  cloudinary_upgrade_asset
			 * @since 3.0.5
			 *
			 * @param $attachment_id {int} The attachment ID.
			 * @param $version       {string} The current plugin version.
			 */
			do_action( 'cloudinary_upgrade_asset', $attachment_id, $this->media->plugin->version );

			$this->media->update_post_meta( $attachment_id, Sync::META_KEYS['plugin_version'], $this->media->plugin->version );
			$this->sync->set_signature_item( $attachment_id, 'upgrade' );

			return $this->media->get_public_id( $attachment_id );
		}
		$file = get_post_meta( $attachment_id, '_wp_attached_file', true );
		if ( ! $this->media->get_post_meta( $attachment_id, Sync::META_KEYS['public_id'], true ) && wp_http_validate_url( $file ) ) {
			// Version 1 upgrade.
			$path                  = wp_parse_url( $file, PHP_URL_PATH );
			$media                 = $this->media;
			$parts                 = explode( '/', ltrim( $path, '/' ) );
			$cloud_name            = null;
			$asset_version         = 1;
			$asset_transformations = array();
			$id_parts              = array();
			$public_id             = $this->get_fetch_public_id( $path, $attachment_id );
			foreach ( $parts as $val ) {
				if ( empty( $val ) ) {
					continue;
				}
				if ( is_null( $cloud_name ) ) {
					// Cloudname will always be the first item.
					$cloud_name = md5( $val );
					continue;
				}
				if ( in_array( $val, array( 'images', 'image', 'video', 'upload', 'fetch' ), true ) ) {
					continue;
				}
				$transformation_maybe = $media->get_transformations_from_string( $val );
				if ( ! empty( $transformation_maybe ) ) {
					$asset_transformations = $transformation_maybe;
					continue;
				}
				if ( substr( $val, 0, 1 ) === 'v' && is_numeric( substr( $val, 1 ) ) ) {
					$asset_version = substr( $val, 1 );
					continue;
				}

				// Filter out file name.
				$path = Utils::pathinfo( $val, PATHINFO_FILENAME );
				if ( ! in_array( $path, $id_parts, true ) ) {
					$id_parts[] = Utils::pathinfo( $val, PATHINFO_FILENAME );
				}
			}
			// Build public_id.
			$parts = array_filter( $id_parts );
			if ( empty( $public_id ) ) {
				$public_id = implode( '/', $parts );
			}
			$this->media->update_post_meta( $attachment_id, Sync::META_KEYS['public_id'], $public_id );
			$this->media->update_post_meta( $attachment_id, Sync::META_KEYS['version'], $asset_version );
			$this->media->update_post_meta( $attachment_id, Sync::META_KEYS['upgrading'], true );
			if ( ! empty( $asset_transformations ) ) {
				Relate::update_transformations( $attachment_id, $asset_transformations );
			}
			$this->sync->set_signature_item( $attachment_id, 'cloud_name', $cloud_name );
		} else {
			// v2 upgrade.
			$public_id = $this->media->get_public_id( $attachment_id, true );
			$suffix    = $this->media->get_post_meta( $attachment_id, Sync::META_KEYS['suffix'], true );
			if ( ! empty( $suffix ) ) {
				// Has suffix. Get delete and cleanup public ID.
				if ( false !== strpos( $public_id, $suffix ) ) {
					$public_id = str_replace( $suffix, '', $public_id );
				}
				$public_id .= $suffix;
				$this->media->delete_post_meta( $attachment_id, Sync::META_KEYS['suffix'] );
				$this->media->update_post_meta( $attachment_id, Sync::META_KEYS['public_id'], $public_id );
			}
			// Check folder sync in order and if it's not a URL.
			if ( ! wp_http_validate_url( $file ) && $this->media->is_folder_synced( $attachment_id ) ) {
				$public_id_folder = ltrim( dirname( $this->media->get_public_id( $attachment_id ) ) );
				$test_signature   = md5( false );
				$folder_signature = md5( $public_id_folder );
				$signature        = $this->sync->get_signature( $attachment_id );
				if ( $folder_signature !== $test_signature && $test_signature === $signature['folder'] ) {
					// The test signature is a hashed false, which is how non-folder-synced items got hashed.
					// Indicating this is broken link.
					$this->media->delete_post_meta( $attachment_id, Sync::META_KEYS['folder_sync'] );
					$this->media->delete_post_meta( $attachment_id, Sync::META_KEYS['sync_error'] ); // Remove any errors from upgrade. they are outdated.
					delete_post_meta( $attachment_id, Sync::META_KEYS['sync_error'] ); // Remove any errors from upgrade. they are outdated.
					$this->sync->set_signature_item( $attachment_id, 'folder' );
				}
			}
		}
		$this->media->update_post_meta( $attachment_id, Sync::META_KEYS['plugin_version'], $this->media->plugin->version );
		$this->sync->set_signature_item( $attachment_id, 'upgrade' );
		$this->sync->set_signature_item( $attachment_id, 'public_id' );
		$this->sync->set_signature_item( $attachment_id, 'storage' );
		// Update Sync keys.
		$sync_key        = $public_id;
		$transformations = $this->media->get_transformation_from_meta( $attachment_id );
		if ( ! empty( $transformations ) ) {
			$sync_key .= wp_json_encode( $transformations );
		}
		update_post_meta( $attachment_id, '_' . md5( $sync_key ), true );
		update_post_meta( $attachment_id, '_' . md5( 'base_' . $public_id ), true );
		// Get a new uncached signature.
		$this->sync->get_signature( $attachment_id, true );

		return $public_id;
	}

	/**
	 * Maybe the upgraded attachment is a fetch image.
	 *
	 * @param string $path          The attachment path.
	 * @param int    $attachment_id The attachment ID.
	 *
	 * @return string
	 */
	public function get_fetch_public_id( $path, $attachment_id ) {
		$parts = explode( '/image/fetch/', $path );

		if ( ! empty( $parts[1] ) ) {
			$this->media->update_post_meta( $attachment_id, Sync::META_KEYS['delivery'], 'fetch' );

			return $parts[1];
		}

		return '';
	}

	/**
	 * Migrate legacy meta data to new meta.
	 *
	 * @param int $attachment_id The attachment ID to migrate.
	 *
	 * @return array();
	 */
	public function migrate_legacy_meta( $attachment_id ) {

		$old_meta = wp_get_attachment_metadata( $attachment_id, true );
		$v2_meta  = get_post_meta( $attachment_id, Sync::META_KEYS['cloudinary_legacy'], true );
		$v3_meta  = array();

		// Direct from old meta to v3, create v2 to chain the upgrade path.
		if ( isset( $old_meta[ Sync::META_KEYS['cloudinary_legacy'] ] ) && empty( $v2_meta ) ) {
			$v2_meta = $old_meta[ Sync::META_KEYS['cloudinary_legacy'] ];
			// Add public ID.
			$public_id                               = get_post_meta( $attachment_id, Sync::META_KEYS['public_id'], true );
			$v2_meta[ Sync::META_KEYS['public_id'] ] = $public_id;
			delete_post_meta( $attachment_id, Sync::META_KEYS['public_id'] );
		}

		// Handle v2 upgrade.
		if ( ! empty( $v2_meta ) ) {
			// Migrate to v3.
			update_post_meta( $attachment_id, Sync::META_KEYS['cloudinary'], $v2_meta );
			delete_post_meta( $attachment_id, Sync::META_KEYS['cloudinary_legacy'] );
			$v3_meta = $v2_meta;
			if ( ! empty( $v3_meta[ Sync::META_KEYS['public_id'] ] ) ) {
				// Cleanup from v2.7.7.
				if ( ! empty( $v3_meta[ Sync::META_KEYS['storage'] ] ) && 'cld' === $v3_meta[ Sync::META_KEYS['storage'] ] ) {
					$file = get_post_meta( $attachment_id, '_wp_attached_file', true );
					if ( $this->media->is_cloudinary_url( $file ) ) {
						$file = path_join( dirname( $old_meta['file'] ), wp_basename( $file ) );
						update_post_meta( $attachment_id, '_wp_attached_file', $file );
						update_post_meta( $attachment_id, '_' . md5( $file ), $file );
					}
				}
			}
			// Remove old data style.
			unset( $old_meta[ Sync::META_KEYS['cloudinary_legacy'] ] );
		}

		// Attempt to update old meta, which will fail if nothing changed.
		update_post_meta( $attachment_id, '_wp_attachment_metadata', $old_meta );

		// migrate from pre v2 meta.
		if ( empty( $v2_meta ) && empty( $v3_meta ) ) {
			// Attempt old post meta.
			$public_id = get_post_meta( $attachment_id, Sync::META_KEYS['public_id'], true );
			if ( ! empty( $public_id ) ) {
				// Loop through all types and create new meta item.
				$v3_meta = array(
					Sync::META_KEYS['public_id'] => $public_id,
				);
				update_post_meta( $attachment_id, Sync::META_KEYS['cloudinary'], $v3_meta );
				foreach ( Sync::META_KEYS as $meta_key ) {
					if ( Sync::META_KEYS['cloudinary'] === $meta_key ) {
						// Dont use the root as it will be an infinite loop.
						continue;
					}
					$value = get_post_meta( $attachment_id, $meta_key, true );
					if ( ! empty( $value ) ) {
						$v3_meta[ $meta_key ] = $value;
						$this->media->update_post_meta( $attachment_id, $meta_key, $value );
					}
				}
			}
		}

		return $v3_meta;
	}

	/**
	 * Setup hooks for the filters.
	 */
	public function setup_hooks() {

		// Add filter to manage legacy items.
		// @todo: cleanup `convert_cloudinary_version` by v2 upgrades to here.
		add_filter( 'cloudinary_migrate_legacy_meta', array( $this, 'migrate_legacy_meta' ) );

		// Add a redirection to the new plugin settings, from the old plugin.
		if ( is_admin() ) {
			add_action(
				'admin_menu',
				function () {
					global $plugin_page;
					if ( ! empty( $plugin_page ) && false !== strpos( $plugin_page, 'cloudinary-image-management-and-manipulation-in-the-cloud-cdn' ) ) {
						wp_safe_redirect( admin_url( '?page=cloudinary' ) );
						die;
					}
				}
			);
		}
	}
}
