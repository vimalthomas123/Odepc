<?php

namespace Hashbar\Block;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Manage_Blocks {
	/**
     * [$_instance]
     * @var null
     */
    private static $_instance = null;

    /**
     * [instance] Initializes a singleton instance
     * @return [Actions]
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
	 * The Constructor.
	 */
	public function __construct() {
		$this->define_constants();
        add_action( 'init', [ $this, 'init' ] );
        add_action( 'enqueue_block_assets', [ $this, 'block_assets' ] );
        add_action( 'enqueue_block_editor_assets', [ $this, 'block_editor_assets' ] );

		if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
			add_filter( 'block_categories_all', array($this, 'register_block_category') );
		} else {
			add_filter( 'block_categories', array($this, 'register_block_category') );
		}
	}

    /**
	 * Define the required plugin constants
	 *
	 * @return void
	 */
	public function define_constants() {
		$this->define( 'HASHBAR_BLOCK_FILE', __FILE__ );
		$this->define( 'HASHBAR_BLOCK_PATH', __DIR__ );
		$this->define( 'HASHBAR_BLOCK_URL', plugins_url( '', HASHBAR_BLOCK_FILE ) );
	}

    /**
     * Define constant if not already set
     *
     * @param  string $name
     * @param  string|bool $value
     * @return type
     */
    private function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }

    public function init(){

		// Return early if this function does not exist.
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		register_block_type(HASHBAR_WPNB_DIR . '/build/blocks/hashbar-countdown');
		register_block_type(HASHBAR_WPNB_DIR . '/build/blocks/promo-banner-img');
		register_block_type(HASHBAR_WPNB_DIR . '/build/blocks/hashbar-promobanner');
		register_block_type(HASHBAR_WPNB_DIR . '/build/blocks/hashbar-notification');

		$this->register_category_pattern();
	}

	public function register_block_category( $categories ) {
		array_unshift($categories, array(
			'slug'  => 'hashbar-blocks',
			'title' => __( 'Hashbar Blocks', 'hashbar' )
		));
	
		return $categories;
	}

    private function register_category_pattern(){
		
		if(function_exists('register_block_pattern_category')){
			register_block_pattern_category(
			    'hashbar',
			    array( 'label' => __( 'Hashbar', 'hashbar' ) )
			);
		}

		if(function_exists('register_block_pattern')){
			register_block_pattern(
			    'hashbar-pro/hashbar-promo-banner',
			    array(
			        'title'       => __( 'Hashbar Promo Banner','hashbar' ),
			        'description' => __( 'Promo Title, Promo content and button for a link.', 'hashbar' ),
			        'categories'  => array('hashbar'),
			        'content'     => "<!-- wp:hashbar/hashbar-promo-banner -->\n<div class=\"wp-block-hashbar-hashbar-promo-banner ht-promo-banner\" style=\"width:250px;background-color:#FB3555;background-image:url(undefined);background-position:center;background-repeat:no-repeat;background-size:cover;border-radius:6px\"><div class=\"ht-content\"><h4 class=\"promo-title\" style=\"font-size:22px;color:#fff\">Add Promo Title</h4><p class=\"promo-summery\" style=\"font-size:17px;color:#fff\">Add Promo Content</p></div><div class=\"ht-promo-button\"><a href=\"#\" style=\"background-color:#fff;color:#1D1E22\">Button</a></div></div>\n<!-- /wp:hashbar/hashbar-promo-banner -->",
			    )
			);

			$img = HASHBAR_WPNB_URI . '/assets/images/promo-image-1.png';
			$content = "<!-- wp:hashbar/hashbar-promo-banner-image -->\n<div class=\"ht-promo-banner-image\"><a href=\"#\"><img src=\"{$img}\" style=\"height:auto;width:250px\"/></a></div>\n<!-- /wp:hashbar/hashbar-promo-banner-image -->";

			register_block_pattern(
			    'hashbar-pro/hashbar-promo-banner-image',
			    array(
			        'title'       => __( 'Hashbar Promo Banner Image','hashbar' ),
			        'description' => __( 'Promo Banner Image', 'hashbar' ),
			        'categories'  => array('hashbar'),
			        'content'     => $content,
			    )
			);
		}
	}

    public function block_assets(){

		wp_enqueue_style(
		    'hashabr-block-style',
		    HASHBAR_WPNB_URI . '/assets/css/block-style-index.css',
		    array(),
		    HASHBAR_WPNB_VERSION
		);

	}

    /**
	 * Block editor assets.
	 */
	public function block_editor_assets() {
		wp_enqueue_style( 'hashbar-block-editor-style', HASHBAR_WPNB_URI . '/assets/css/block-editor-style.css', false, HASHBAR_WPNB_VERSION, 'all' );
		wp_enqueue_style( 'hashbar-pro-frontend', HASHBAR_WPNB_URI.'/assets/css/frontend.css', '', time());
		wp_enqueue_script( 'jquery-countdown', HASHBAR_WPNB_URI.'/assets/js/jquery.countdown.min.js', array('jquery'),HASHBAR_WPNB_VERSION, true);

		wp_localize_script(
			'wp-blocks',
			'hashbarBlockParams',
			[
				'ntfId'   			=>  get_the_id(),
				'bannerImageURL'   	=>  HASHBAR_WPNB_URI . '/assets/images/promo-image-1.png',
			]
		);
	}
}

Manage_Blocks::instance();