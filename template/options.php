<div class="wrap">
	<h2>Flickr Random Get - Set Paramater</h2>
	<form action="options.php" method="post">
		<?php wp_nonce_field('update-options'); ?>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="flickrRandomPhotoAPIKey">Flickr API Key</label></th>
					<td><input name="flickrRandomPhotoAPIKey" type="text" id="flickrRandomPhotoAPIKey" value="<?php echo get_option('flickrRandomPhotoAPIKey'); ?>" class="regular-text"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="flickrRandomPhotoAPISecret">Flickr API Secret</label></th>
					<td><input name="flickrRandomPhotoAPISecret" type="text" id="flickrRandomPhotoAPISecret" value="<?php echo get_option('flickrRandomPhotoAPISecret'); ?>" class="regular-text"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="flickrRandomPhotoUserID">Flickr User ID</label></th>
					<td><input name="flickrRandomPhotoUserID" type="text" id="flickrRandomPhotoUserID" value="<?php echo get_option('flickrRandomPhotoUserID'); ?>" class="regular-text"></td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="flickrRandomPhotoAPIKey,flickrRandomPhotoAPISecret,flickrRandomPhotoUserID" />
		<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
	</form>
</div>