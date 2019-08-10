<?php 
/**
 * @author 
 */
Class ACFTOAPI{

	/**
	 * Set false if you want to 
	 */
	public $newKeyForACF = true;
  
	public function __construct(){
	 
	}
	//
	public function register(){
		add_action( 'rest_api_init', [$this,'postTypes'], 10 );
	}
	
	private function getKeyName(){
		return get_option('pk_acfwpapi_newfield_name') ?: 'acf';
	}

	private function getNewKey(){
		return get_option('pk_acfwpapi_newfield') ?: false;
	}
	/**
	 * Register acf fields for each post type if the post has any acf fields
	 */
	public function postTypes(){
		global $wp_post_types;
		$post_types = array_keys( $wp_post_types );
		//remove wp cpts
		$post_types = array_diff($post_types,['attachment','revision','nav_menu_item','custom_css','customize_changeset','oembed_cache','user_request','wp_block','acf-field-group','acf-field']);
  
		foreach ($post_types as $post_type) {
			add_filter( "rest_prepare_{$post_type}", function($data, $post, $request){
			if ( is_wp_error( $data ) ) return $data;
		
			$response = $data->get_data();
			
			$acf_fields = get_fields($post->ID);
			if ($acf_fields){
				foreach ($acf_fields as $field_key => $field_value){
					if($this->getNewKey())
						$response[$this->getKeyName()][$field_key] = $field_value;
					else
						$response[$field_key] = $field_value;
				}
			}
			$data->set_data( $response );
			return $data;
			}, 10, 3);
		}
	}

	/**
	 * Register acf fields for each taxonomy if the taxonomy has any acf fields
	 */
	public function taxonomies(){
		//todo
		return;
	}
  }