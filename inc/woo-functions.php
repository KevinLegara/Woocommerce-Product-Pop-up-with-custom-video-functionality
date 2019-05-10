<?php
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );
	function custom_woocommerce_product_add_to_cart_text() {
		global $product;
		$product_type = $product->get_type();		
		return 'Buy it Now';
	}

	add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
	function woo_new_product_tab( $tabs ) {
		$tabs['reviews']['title'] = __( 'Reviews' );
		$tabs['desc_tab'] = array(
			'title'     => __( 'Additional Info', 'woocommerce' ),
			'priority'  => 50,
			'callback'  => 'woo_new_product_tab_content'
		);
		return $tabs;
	}

	function woo_new_product_tab_content() {
	  // The new tab content
	  echo '<p>Lorem Ipsum</p>';
	}
