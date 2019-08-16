<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXCPFCMetaboxesclass
{

	/*
	* MXCPFCMetaboxesclass constructor
	*/
	public function __construct()
	{		

	}

	/*
	* Create Metaboxes
	*/
	public static function createMetaboxes()
	{

		add_action( 'add_meta_boxes', array( 'MXCPFCMetaboxesclass', 'mxcpfc_metaboxes_init' ) );

		// save metabox data of price per word
		add_action( 'save_post', array( 'MXCPFCMetaboxesclass', 'meta_data_price_per_word_save' ) );

		// save metabox data of count of words
		add_action( 'save_post', array( 'MXCPFCMetaboxesclass', 'meta_data_count_of_words_save' ) );

		// save metabox data of amount
		add_action( 'save_post', array( 'MXCPFCMetaboxesclass', 'meta_data_of_amount_save' ) );

		// save metabox data of URL to client
		add_action( 'save_post', array( 'MXCPFCMetaboxesclass', 'meta_data_url_to_client_save' ) );

		// save metabox data of customer email
		add_action( 'save_post', array( 'MXCPFCMetaboxesclass', 'meta_data_customer_email_save' ) );

		// save metabox data of invoice number
		add_action( 'save_post', array( 'MXCPFCMetaboxesclass', 'meta_data_invoice_number_save' ) );
			
		// save metabox data of invoice number
		add_action( 'save_post', array( 'MXCPFCMetaboxesclass', 'meta_data_currency_save' ) );	

		// save metabox data of offer
		add_action( 'save_post', array( 'MXCPFCMetaboxesclass', 'meta_data_offer_save' ) );

		// save metabox data of offer
		add_action( 'save_post', array( 'MXCPFCMetaboxesclass', 'meta_data_url_hash_save' ) );
				
	}

		/*
		* Metabox initialization
		*/
		public static function mxcpfc_metaboxes_init() {


			// metabox of price per word
			add_meta_box(
				'meta_price_per_word',
				'Price per word',
				array( 'MXCPFCMetaboxesclass', 'metabox_of_price_per_word' ),
				'mxcpfc_payment',
				'normal',
				'default'
			);

			// metabox of price per word
			add_meta_box(
				'meta_url_hash',
				'Url Hash',
				array( 'MXCPFCMetaboxesclass', 'metabox_of_meta_url_hash' ),
				'mxcpfc_payment',
				'normal',
				'default'
			);

			// metabox currency
			add_meta_box(
				'meta_currency',
				'Currency',
				array( 'MXCPFCMetaboxesclass', 'metabox_currency' ),
				'mxcpfc_payment',
				'normal',
				'default'
			);

			// metabox of count of words
			add_meta_box(
				'meta_count_of_words',
				'Count of words',
				array( 'MXCPFCMetaboxesclass', 'metabox_of_count_of_words' ),
				'mxcpfc_payment',
				'normal',
				'default'
			);

			// metabox of amount
			add_meta_box(
				'meta_of_amount',
				'Price amount (how much it costs)',
				array( 'MXCPFCMetaboxesclass', 'metabox_of_amount' ),
				'mxcpfc_payment',
				'normal',
				'default'
			);

			// metabox of URL to client
			add_meta_box(
				'meta_url_to_client',
				'URL to client (autogenerated)',
				array( 'MXCPFCMetaboxesclass', 'metabox_of_url_to_client' ),
				'mxcpfc_payment',
				'normal',
				'default'
			);

			// metabox of customer email
			add_meta_box(
				'meta_customer_email',
				'Customer email',
				array( 'MXCPFCMetaboxesclass', 'metabox_of_customer_email' ),
				'mxcpfc_payment',
				'normal',
				'default'
			);

			// metabox of invoice number
			add_meta_box(
				'meta_invoice_number',
				'Invoice number',
				array( 'MXCPFCMetaboxesclass', 'metabox_of_invoice_number' ),
				'mxcpfc_payment',
				'normal',
				'default'
			);

			// metabox of offer
			add_meta_box(
				'meta_offer',
				'Offer',
				array( 'MXCPFCMetaboxesclass', 'metabox_offer' ),
				'mxcpfc_payment',
				'normal',
				'default'
			);

			// metabox has sent
			add_meta_box(
				'meta_sent_to_client',
				'Sending payment request to client',
				array( 'MXCPFCMetaboxesclass', 'metabox_sent_to_client' ),
				'mxcpfc_payment',
				'normal',
				'default'
			);

		}

		/*
		* Metabox of sent to client
		*/
		public static function metabox_sent_to_client( $post, $box ) {			

			$data = get_post_meta( $post->ID, '_meta_sent_to_client_data', true );

			wp_nonce_field( 'meta_sent_to_client_action', 'meta_sent_to_client_nonce' );

			// payment confirm
			$data_payment_confirm = get_post_meta( $post->ID, '_meta_bill_confirm', true );

			if( $data_payment_confirm == 'confirm' ) { ?>

				<h4><u>Client already has paid for this bill.</u></h4>
				<h5>If you want to add new payment request, please, create new payment item.</h5>

			<?php } else {

				if( esc_attr($data) == '' ) {

					echo '<p id="mx_send_payment_to_client_text">Do you want to send this payment to the client?</p>';

					echo '<p><button class="button button-primary button-large" id="mx_send_payment_to_client" data-post-id="' . $post->ID . '">Send Payment</button></p>';

				} else {

					echo '<p id="mx_send_payment_to_client_text">You have sent payment to the client. Do you want do it one more time?</p>';

					echo '<p><button class="button button-primary button-large" id="mx_send_payment_to_client" data-post-id="' . $post->ID . '">Send Payment Again</button></p>';

				}

			}

		}
		/*____________________________________________________________________*/

		/*
		* Metabox of offer
		*/
		public static function metabox_offer( $post, $box ) {			

			$data = get_post_meta( $post->ID, '_meta_offer_data', true );

			wp_nonce_field( 'meta_offer_action', 'meta_offer_nonce' );

			echo '<p>Offer: <input type="text" data-invoice-number="' . $post->ID . '" name="meta_of_offer_field" id="meta_of_offer_field" value="' 
			. esc_attr($data) . '" required /></p>';

		}

			// save meta of invoice number
			public static function meta_data_offer_save( $postID ) {

				if ( !isset( $_POST['meta_of_offer_field'] ) )
					return; 

				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
					return; 

				if ( wp_is_post_revision( $postID ) )
					return; 

				if( !current_user_can( 'edit_post', $postID ) )
					return;

				$data = sanitize_text_field( $_POST['meta_of_offer_field'] );

				update_post_meta( $postID, '_meta_offer_data', $data );

			}
		/*____________________________________________________________________*/

		/*
		* Metabox of invoice number
		*/
		public static function metabox_of_invoice_number( $post, $box ) {			

			$data = get_post_meta( $post->ID, '_meta_invoice_number_data', true );

			wp_nonce_field( 'meta_invoice_number_action', 'meta_invoice_number_nonce' );

			echo '<p>Invoice number: <input type="text" data-invoice-number="' . $post->ID . '" name="meta_of_invoice_number_field" id="meta_of_invoice_number_field" value="' 
			. esc_attr($data) . '" readonly /></p>';

		}

			// save meta of invoice number
			public static function meta_data_invoice_number_save( $postID ) {

				if ( !isset( $_POST['meta_of_invoice_number_field'] ) )
					return; 

				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
					return; 

				if ( wp_is_post_revision( $postID ) )
					return; 

				if( !current_user_can( 'edit_post', $postID ) )
					return;

				$data = sanitize_text_field( $_POST['meta_of_invoice_number_field'] );

				update_post_meta( $postID, '_meta_invoice_number_data', $data );

			}
		/*____________________________________________________________________*/

		/*
		* Metabox of customer email
		*/
		public static function metabox_of_customer_email( $post, $box ) {			

			$data = get_post_meta( $post->ID, '_meta_customer_email_data', true ); 

			wp_nonce_field( 'meta_customer_email_action', 'meta_customer_email_nonce' ); 

			echo '<p>Customer email: <input type="email" name="meta_of_customer_email_field" id="meta_of_customer_email_field" value="' 
			. esc_attr($data) . '" required /></p>';

		}

			// save meta of customer email
			public static function meta_data_customer_email_save( $postID ) {

				if ( !isset( $_POST['meta_of_customer_email_field'] ) ) 
					return; 

				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
					return; 

				if ( wp_is_post_revision( $postID ) ) 
					return; 

				if( !current_user_can( 'edit_post', $postID ) )
					return;

				$data = sanitize_email( $_POST['meta_of_customer_email_field'] ); 

				update_post_meta( $postID, '_meta_customer_email_data', $data );

			}
		/*____________________________________________________________________*/

		/*
		* Metabox of URL to client
		*/
		public static function metabox_of_meta_url_hash( $post, $box ) {

			$data = get_post_meta( $post->ID, '_meta_url_hash_data', true );

			wp_nonce_field( 'meta_url_hash_action', 'meta_url_hash_nonce' ); 

			echo '<p>Url Hash: <input type="text" data-url-path="' . get_home_url() . '/wordpress/payment-confirmation/" name="meta_of_url_hash_field" id="meta_of_url_hash_field" value="' 
			. esc_attr($data) . '" readonly required /></p>';

		}

			// save meta of URL to client
			public static function meta_data_url_hash_save( $postID ) {

				if ( !isset( $_POST['meta_of_url_hash_field'] ) ) 
					return; 

				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
					return; 

				if ( wp_is_post_revision( $postID ) ) 
					return; 

				if( !current_user_can( 'edit_post', $postID ) )
					return;

				$data = sanitize_text_field( $_POST['meta_of_url_hash_field'] ); 

				update_post_meta( $postID, '_meta_url_hash_data', $data );

			}
		/*____________________________________________________________________*/


		/*
		* Metabox of URL to client
		*/
		public static function metabox_of_url_to_client( $post, $box ) {

			$data = get_post_meta( $post->ID, '_meta_url_to_client_data', true );

			wp_nonce_field( 'meta_url_to_client_action', 'meta_url_to_client_nonce' ); 

			echo '<p>URL to client: <input type="text" data-url-path="' . get_home_url() . '/wordpress/payment-confirmation/" name="meta_of_url_to_client_field" id="meta_of_url_to_client_field" value="' 
			. esc_attr($data) . '" readonly required /></p>';

		}

			// save meta of URL to client
			public static function meta_data_url_to_client_save( $postID ) {

				if ( !isset( $_POST['meta_of_url_to_client_field'] ) ) 
					return; 

				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
					return; 

				if ( wp_is_post_revision( $postID ) ) 
					return; 

				if( !current_user_can( 'edit_post', $postID ) )
					return;

				$data = esc_url_raw( $_POST['meta_of_url_to_client_field'] ); 

				update_post_meta( $postID, '_meta_url_to_client_data', $data );

			}
		/*____________________________________________________________________*/

		/*
		* Metabox of amount
		*/
		public static function metabox_of_amount( $post, $box ) {			

			$data = get_post_meta( $post->ID, '_meta_of_amount_data', true ); 

			wp_nonce_field( 'meta_of_amount_action', 'meta_of_amount_nonce' ); 

			echo '<p>Price amount: <input type="text" name="meta_of_amount_field" id="meta_of_amount_field" value="' 
			. esc_attr($data) . '" required /></p>';

		}

			// save meta of amount
			public static function meta_data_of_amount_save( $postID ) {

				if ( !isset( $_POST['meta_of_amount_field'] ) ) 
					return; 

				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
					return; 

				if ( wp_is_post_revision( $postID ) ) 
					return; 

				if( !current_user_can( 'edit_post', $postID ) )
					return;

				$data = sanitize_text_field( $_POST['meta_of_amount_field'] ); 

				update_post_meta( $postID, '_meta_of_amount_data', $data );

			}
		/*____________________________________________________________________*/

		/*
		* Metabox of count of words
		*/
		public static function metabox_of_count_of_words( $post, $box ) {			

			$data = get_post_meta( $post->ID, '_meta_count_of_words_data', true ); 

			wp_nonce_field( 'meta_count_of_words_action', 'meta_count_of_words_nonce' ); 

			echo '<p>Count of words: <input type="text" name="meta_count_of_words_field" id="meta_count_of_words_field" value="' 
			. esc_attr($data) . '" required /></p>';

		}

			// save meta count of words
			public static function meta_data_count_of_words_save( $postID ) {

				if ( !isset( $_POST['meta_count_of_words_field'] ) ) 
					return; 

				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
					return; 

				if ( wp_is_post_revision( $postID ) ) 
					return; 

				if( !current_user_can( 'edit_post', $postID ) )
					return;

				$data = sanitize_text_field( $_POST['meta_count_of_words_field'] ); 

				update_post_meta( $postID, '_meta_count_of_words_data', $data );

			}
		/*____________________________________________________________________*/
		
		/*
		* Metabox of currency
		*/
		public static function metabox_currency( $post, $box ) {			

			$data = get_post_meta( $post->ID, '_meta_currency_data', true ); 

			wp_nonce_field( 'meta_currency_action', 'meta_currency_nonce' ); 

			echo '<p>Currency: <input type="text" name="meta_currency_field" id="meta_currency_field" value="' 
			. esc_attr($data) . '" required /></p>';

		}

			// save meta currency
			public static function meta_data_currency_save( $postID ) {

				if ( !isset( $_POST['meta_currency_field'] ) ) 
					return; 

				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
					return; 

				if ( wp_is_post_revision( $postID ) ) 
					return; 

				if( !current_user_can( 'edit_post', $postID ) )
					return;

				$data = sanitize_text_field( $_POST['meta_currency_field'] ); 

				update_post_meta( $postID, '_meta_currency_data', $data );

			}
		/*____________________________________________________________________*/

		/*
		* Metabox of price per word
		*/
		public static function metabox_of_price_per_word( $post, $box ) {			

			$data = get_post_meta( $post->ID, '_meta_price_per_word_data', true ); 

			wp_nonce_field( 'meta_price_per_word_action', 'meta_price_per_word_nonce' ); 

			echo '<p>Price per word: <input type="text" name="meta_price_per_word_field" id="meta_price_per_word_field" value="' 
			. esc_attr($data) . '" required /></p>';

		}

			// save meta price per word
			public static function meta_data_price_per_word_save( $postID ) {

				if ( !isset( $_POST['meta_price_per_word_field'] ) ) 
					return; 

				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
					return; 

				if ( wp_is_post_revision( $postID ) ) 
					return; 

				if( !current_user_can( 'edit_post', $postID ) )
					return;

				$data = sanitize_text_field( $_POST['meta_price_per_word_field'] ); 

				update_post_meta( $postID, '_meta_price_per_word_data', $data );

			}
		/*____________________________________________________________________*/

}