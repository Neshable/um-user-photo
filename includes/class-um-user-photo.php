<?php


/**
 * The core plugin class.
 *
 *
 * @since      1.0.0
 * @package    UM_User_Photo
 * @author     Nesho Sabakov <neshosab16@gmail.com>
 */

class UM_User_Photo {

	/**
	 * Define the core functionality of the plugin and all hooks
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		// Hooks to show the fields in user-edit.php
		add_action( 'show_user_profile', array( $this, 'um_user_photo_fields' ), 10, 1 );
		add_action( 'edit_user_profile', array( $this, 'um_user_photo_fields' ), 10, 1 );

		// Use profile_update hook to update the new fields
		add_action('profile_update', array( $this, 'um_user_photo_fields_update' ));

	}

	// Function to display the input for the custom fields
	public function um_user_photo_fields() {
	?>
		<table class="form-table">
			<tr>
				<th>
					<label for="photo_url"><?php esc_html_e( 'UM Profile Photo' ); ?></label>
				</th>
				<td>
				<?php
				// This will enqueue the Media Uploader script
				wp_enqueue_media();
				?>
			
				<script type="text/javascript">
				jQuery(document).ready(function($){
				    $('#upload-btn').click(function(e) {
				        e.preventDefault();
				        var image = wp.media({ 
				            title: 'Upload Image',
				            // mutiple: true if you want to upload multiple files at once
				            multiple: false
				        }).open()
				        .on('select', function(e){
				            // This will return the selected image from the Media Uploader, the result is an object
				            var uploaded_image = image.state().get('selection').first();
				            // We convert uploaded_image to a JSON object to make accessing it easier
				            var photo_url = uploaded_image.toJSON().url;
				            // Let's assign the url value to the input field
				            $('#photo_url').val(photo_url);
				        });
				    });
				});
				</script>
					<input type="text" name="photo_url" id="photo_url" class="regular-text">
				    <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Choose from Library">
					<br><span class="description"><?php esc_html_e( 'Paste link to the photo or choose from the Media Library'); ?></span>
				</td>
			</tr>
		</table>
	<?php
	}

	// Update the user meta - um profile image
	public function um_user_photo_fields_update( $user_id ) {
	     if ( current_user_can('edit_user',$user_id) ) {
	        // Add profile image via Ultimate member 2.0.14
			UM()->files()->new_user_upload( $user_id, $_POST['photo_url'], 'profile_photo' );
	     }
	 }

}
