<?php

// wpSAP: Filter get_avatar()
add_filter( 'get_avatar' , 'wpsap_get_avatar_filter' , 1 , 5 );
function wpsap_get_avatar_filter( $avatar, $id_or_email, $size, $default, $alt ){
	global $wpsapOptions;
    $user = false;
	
	if( $wpsapOptions['avatarEnabled'] ){
		if( is_numeric($id_or_email) ){

			$id = (int) $id_or_email;
			$user = get_user_by( 'id' , $id );

		}elseif ( is_object( $id_or_email ) ){

			if ( !empty( $id_or_email->user_id ) ){
				$id = (int) $id_or_email->user_id;
				$user = get_user_by('id' , $id);
			}

		}else{
			$user = get_user_by('email', $id_or_email);
		}

		if( $user && is_object($user) ){
				
			$steam_wp_avatar = get_user_meta($user->data->ID, 'steam_wp_avatar', true);
			if( !empty($steam_wp_avatar) ){
				$avatar = get_user_meta($user->data->ID, 'steam_wp_avatar', true);
				$avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
			}
				
		}
	}

    return $avatar;
}

// wpSAP: Filter get_avatar_url()
add_filter( 'get_avatar_url', 'wpsap_get_avatar_url_filter', 10, 3 ); 
function wpsap_get_avatar_url_filter( $url, $id_or_email, $args ){
	global $wpsapOptions;
    $user = false;
	
	if( $wpsapOptions['avatarEnabled'] ){
		if( is_numeric($id_or_email) ){

			$id = (int) $id_or_email;
			$user = get_user_by( 'id' , $id );

		}elseif ( is_object( $id_or_email ) ){

			if ( !empty( $id_or_email->user_id ) ){
				$id = (int) $id_or_email->user_id;
				$user = get_user_by('id' , $id);
			}

		}else{
			$user = get_user_by('email', $id_or_email);
		}

		if( $user && is_object($user) ){
				
			$steam_wp_avatar = get_user_meta($user->data->ID, 'steam_wp_avatar', true);
			if( !empty($steam_wp_avatar) ){
				$url = $steam_wp_avatar;
			}
				
		}
	}
	
	return $url; 
};

// wpSAP: Filter BP_avatar
add_filter( 'bp_core_fetch_avatar', 'wpsap_bp_avatar_filter', 10, 2 );
function wpsap_bp_avatar_filter( $args, $params  ) {
	
	if($params['object'] == 'user' && is_int($params['item_id'])){
		$steam_wp_avatar = get_user_meta($params['item_id'], 'steam_wp_avatar', true);
		if( !empty($steam_wp_avatar) && strpos($args, get_site_url()) === false ){
			
			return preg_replace( '/src=".+?"/', 'src="' . $steam_wp_avatar . '"', $args );
			
			//return '<img src="' . $steam_wp_avatar . '" />';
			//return apply_filters( 'bp_core_fetch_avatar_url', $steam_wp_avatar, $params );
			//return apply_filters( 'bp_core_fetch_avatar', '<img src="' . $steam_wp_avatar . '"' . $html_class . $html_css_id  . $html_width . $html_height . $html_alt . $html_title . $extra_attr . ' />', $params, $params['item_id'], $params['avatar_dir'], $html_css_id, $html_width, $html_height, $avatar_folder_url, $avatar_folder_dir );
		}
	}
	
	return $args;
	
}

// wpSAP: Filter option to sanitize slugSteamApp
add_filter( 'pre_update_option_wpsapSettings_steamAppUrl', 			'wpsap_sanitize_slug', 10, 2 );
add_filter( 'pre_update_option_wpsapSettings_steamAppLoginUrl', 	'wpsap_sanitize_slug', 10, 2 );
add_filter( 'pre_update_option_wpsapSettings_steamAppSyncUrl', 		'wpsap_sanitize_slug', 10, 2 );
add_filter( 'pre_update_option_wpsapSettings_steamAppLogoutUrl', 	'wpsap_sanitize_slug', 10, 2 );
function wpsap_sanitize_slug( $new_value, $old_value ) {
	$new_value = sanitize_title( $new_value );
	return $new_value;
}

// wpSAP: Rewrite Rules
add_action('generate_rewrite_rules', 'wpsap_steamapp_rewrite_rule' );
function wpsap_steamapp_rewrite_rule($wp_rewrite) {
	global $wpsapConfig;
	
	$keytag = '%wpsap_action%';
	$wp_rewrite->add_rewrite_tag($keytag, '([^/]*)', 'wpsap_action=');
	
	$slash = (!empty($wpsapConfig['slugSteamApp'])) ? '/' : '';
	
	$new_rules = array(
		$wpsapConfig['slugSteamApp'] . $slash . $wpsapConfig['slugLogin'] . '/?$' => 	'index.php?wpsap_action=login',
		$wpsapConfig['slugSteamApp'] . $slash . $wpsapConfig['slugLogged'] . '/?$' => 	'index.php?wpsap_action=logged',
		$wpsapConfig['slugSteamApp'] . $slash . $wpsapConfig['slugSync'] . '/?$' => 	'index.php?wpsap_action=sync',
		$wpsapConfig['slugSteamApp'] . $slash . $wpsapConfig['slugLogout'] . '/?$' => 	'index.php?wpsap_action=logout'
	);

	$wp_rewrite->rules = array_merge($new_rules, $wp_rewrite->rules);
}

// wpSAP: Query Vars
add_filter('query_vars', 'wpsap_steamapp_query_vars');
function wpsap_steamapp_query_vars($query_vars){
    $query_vars[] = 'wpsap_action';
    return $query_vars;
}

// wpSAP: Flush Rewrite on Update
add_action('admin_init', 'wpsap_steamapp_flush_rewrite');
function wpsap_steamapp_flush_rewrite() {
    if ( get_option('wpsapSettings_steamAppFlush') == 1 ){
        flush_rewrite_rules();
        update_option('wpsapSettings_steamAppFlush', 0);
    }
}


// wpSAP: WP Users Steam - Column Filter
add_filter( 'manage_users_columns', 'wpsap_users_table_column' );
function wpsap_users_table_column( $column ) {
    $column['wpsap_linked'] = 'Steam';
    $column['wpsap_linked_last'] = 'Sync. date';
    return $column;
}

// wpSAP: WP Users Steam - Row Filter
add_filter( 'manage_users_custom_column', 'wpsap_users_table_row', 10, 3 );
function wpsap_users_table_row( $val, $column_name, $user_id ) {
	if($column_name == 'wpsap_linked'){
		//return get_the_author_meta( 'steam_steamid', $user_id );
		$get_user = get_the_author_meta('steam_steamid', $user_id );
		if(!empty($get_user)){
			return '<i class="fa fa-steam"></i>';
		}else{
			return '<i class="fa fa-steam" style="color:#ccc;"></i>';
		}
		
	}elseif($column_name == 'wpsap_linked_last'){
		$get_user_steam_update = get_the_author_meta('steam_uptodate', $user_id );
		if(!empty($get_user_steam_update)){
			$return  = '<div>' . date('d/m/Y H:i:s', get_the_author_meta('steam_uptodate', $user_id )) . '</div>';
			
			$get_user_force_resync = get_the_author_meta('steam_force_resync', $user_id );
			if(!empty($get_user_force_resync)){
				$return .= '<div><span><small style="color:#a00;">ReSync Forced</small></div>';
			}
			
			return $return;
			
		}else{
			return '<div style="color:#ccc;">Never</div>';
		}
		
		
	}
	return $val;
}

// wpSAP: WP Users Steam - Bulk Revoke
add_action('admin_footer', 'wpsap_users_table_bulk');
function wpsap_users_table_bulk() {
    $screen = get_current_screen();
    if ( $screen->id != "users" || !current_user_can('manage_options') )
        return;
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('<option>').val('wpsap_revoke_token').text('Force Steam ReSync.').appendTo("select[name='action']");
        });
    </script>
    <?php
}

// wpSAP: WP Users Steam - Single Revoke Link
add_filter( 'user_row_actions', 'wpsap_users_table_single', 10, 2 );
function wpsap_users_table_single( $actions, $user ){
    if ( current_user_can('manage_options') && get_user_meta($user->ID, 'steam_steamid', true) && !get_user_meta($user->ID, 'steam_force_resync', true) ){
        $actions['wpsap_revoke_token'] = '<a href="?action=wpsap_revoke_token&users[]='.$user->ID.'">Force Steam ReSync.</a>';
		
	}
    return $actions;
}

// wpSAP: WP Users Steam - Bulk Revoke Action
add_action('load-users.php', 'wpsap_users_table_bulk_action');
function wpsap_users_table_bulk_action() {
    if( isset($_GET['action']) && $_GET['action'] === 'wpsap_revoke_token' && current_user_can('manage_options') ){ 
        $selected_users = $_GET['users'];
        if ($selected_users) {
            foreach ($selected_users as $user) {
				if(get_user_meta($user, 'steam_steamid', true)){
					update_user_meta($user, 'steam_force_resync', 1);
					$sessions = WP_Session_Tokens::get_instance($user);
					$sessions->destroy_all();
				}
            }
        }
    }
}

// wpSAP: WP Users Profile Display Fields
add_action( 'show_user_profile', 'wpsap_users_profile_display_fields' );
add_action( 'edit_user_profile', 'wpsap_users_profile_display_fields' );
function wpsap_users_profile_display_fields($user){
	
	if( get_user_meta($user->ID, 'steam_steamid', true) ){
    ?>
        <h3>Steam Profile</h3>

        <table class="form-table">
            <tr>
                <th><label for="steam_steamid">Steam ID (base64)</label></th>
                <td><?php echo esc_attr(get_the_author_meta( 'steam_steamid', $user->ID )); ?></td>
            </tr>
            <tr>
                <th><label for="steam_personaname">Nickname</label></th>
                <?php if(current_user_can('manage_options')){ ?>
					<td><input type="text" name="wpsap_steam_personaname" value="<?php echo esc_attr(get_the_author_meta( 'steam_personaname', $user->ID )); ?>" class="regular-text" /></td>
				<?php }else{ ?>
					<td><?php echo esc_attr(get_the_author_meta( 'steam_personaname', $user->ID )); ?></td>
				<?php } ?>
            </tr>
			<tr>
                <th><label for="steam_realname">Real name</label></th>
                <?php if(current_user_can('manage_options')){ ?>
					<td><input type="text" name="wpsap_steam_realname" value="<?php echo esc_attr(get_the_author_meta( 'steam_realname', $user->ID )); ?>" class="regular-text" /></td>
				<?php }else{ ?>
					<td><?php echo esc_attr(get_the_author_meta( 'steam_realname', $user->ID )); ?></td>
				<?php } ?>
            </tr>
            <tr>
                <th><label for="steam_profileurl">Profile</label></th>
				<td><a href="<?php echo esc_attr(get_the_author_meta( 'steam_profileurl', $user->ID )); ?>" target="_blank"><?php echo esc_attr(get_the_author_meta( 'steam_profileurl', $user->ID )); ?></a></td>
            </tr>
			
			<?php if(current_user_can('manage_options')){ ?>
            <tr>
                <th><label for="steam_avatar">Avatar</label></th>
                <td><img src="<?php echo esc_attr(get_the_author_meta( 'steam_avatar', $user->ID )); ?>" /></td>
				
            </tr>
			<?php } ?>
			
            <tr>
                <th><label>Last Sync.</label></th>
                <td><?php echo date('d/m/Y H:i:s', esc_attr(get_the_author_meta( 'steam_uptodate', $user->ID ))); ?></td>
            </tr>
			
			<?php if(current_user_can('manage_options')){ ?>
            <tr>
                <th scope="row"><label for="wpsap_steam_force_resync">Force ReSync.</label></th>
                <td>
					<input type="checkbox" name="wpsap_steam_force_resync" value="1" />
					<p class="description">This will instantly logout the user. On the next login with Steam, the WP Steam Profile will be updated with latest Steam data (Profile URL, Avatar, Sync. date etc...)</p>
				</td>
            </tr>
			<script>
				jQuery(document).ready( function($) {
					$('input[name=wpsap_steam_remove_sync]').change(function(){
						if ($('input[name=wpsap_steam_remove_sync]').is(':checked') == true){
							confirm('WARNING: This action cannot be undone. Are you sure?')
						}
					});
				});
			</script>
			<tr>
                <th scope="row"><label for="wpsap_steam_remove_sync">Remove Steam Sync.</label></th>
                <td>
					<input type="checkbox" name="wpsap_steam_remove_sync" value="1" />
					<p class="description" style="color:red;"><u>Warning:</u> This will remove the WP Steam Profile. The user won't be able to log back via Steam. He will need to login via legacy WP method and then synchronize manually.</p>
				</td>
            </tr>
			
			<?php } ?>

        </table>
    <?php
	}
}

// wpSAP: WP Users Profile Save Fields
add_action( 'personal_options_update', 'wpsap_users_profile_save_fields' );
add_action( 'edit_user_profile_update', 'wpsap_users_profile_save_fields' );
function wpsap_users_profile_save_fields($user_id){
	if(current_user_can('manage_options')){
		
		update_user_meta( $user_id, 'steam_personaname', 	sanitize_text_field( $_POST['wpsap_steam_personaname'] ) );
		update_user_meta( $user_id, 'steam_realname', 		sanitize_text_field( $_POST['wpsap_steam_realname'] ) );
		
		if($_POST['wpsap_steam_force_resync'] == 1){
			update_user_meta($user_id, 'steam_force_resync', 1);
			$sessions = WP_Session_Tokens::get_instance($user_id);
			$sessions->destroy_all();
		}
		
		if($_POST['wpsap_steam_remove_sync'] == 1){
			global $wpsapOptions;
			foreach($wpsapOptions['metaFields'] as $field){
				$field_name = 'steam_'.$field;
				delete_user_meta($user_id, $field_name);
			}
			delete_user_meta($user_id, 'steam_wp_avatar');
			$sessions = WP_Session_Tokens::get_instance($user_id);
			$sessions->destroy_all();
		}
		
	}
}

add_action('admin_head', 'wpsap_admin_head_css');
function wpsap_admin_head_css() {
	echo '
	<style>
		.fixed .column-wpsap_linked{width:74px;}
		.fixed .column-wpsap_linked_last{width:150px;}
		.column-wpsap_linked{text-align:center !important;}
	</style>
  ';
}

add_action( 'admin_enqueue_scripts', 'wpsap_enqueue_font_awesome' );
function wpsap_enqueue_font_awesome() {
	wp_enqueue_script(
		'font-awesome',
		'https://use.fontawesome.com/a8cfa4d4fc.js',
		FALSE,
		NULL
	);
}