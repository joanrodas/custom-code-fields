<?php

namespace CPF\Field;

class ImageField extends Field
{

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), $key, true);
        $image = $value ? wp_get_attachment_image_url($value) : '';
        ob_start(); ?>
        <p class="form-field _<?= $this->type ?>_field" x-data="{ image_file: false, image_src: '<?= $image ?>' }">
            <label for="<?= $key ?>"><?= $this->name ?></label>
            <label style="width: 50%; box-sizing: border-box; margin: 0; float: none; cursor: pointer; padding: 1rem; border: 2px dashed #2271b1; display: block; border-radius: 4px;" for="<?= $key ?>">
                <input type="file" accept="image/*" style="display: none;" name="<?= $key ?>" id="<?= $key ?>" @change="image_file = $event.target.files > 0 ? $event.target.files[0] : false; image_src = (image_file ? URL.createObjectURL(image_file) : '')">
                <input type="hidden" :value="image_src" name="<?= $key ?>_src">
                <span x-text="image_src ? '' : 'Choose image'"></span>
                <span style="display: flex; gap: 1rem; align-items: center;">
                    <template x-cloak x-if="image_src">
                        <img style="width: 4rem; height: 4rem; object-fit: contain;" :src="image_src" alt="image_file ? image_file.name : ''" />
                    </template>
                </span>
            </label>

            <button type="reset" @click="image_file = false; image_src = ''" style="margin: 0.5rem 0 0; background-color: #ccc; border: 2px solid #ccc; padding: 0.25rem 0.75rem; border-radius: 4px; cursor: pointer;">Reset</button>
        </p>
        <?php echo ob_get_clean();
	}
    
    public function display_complex($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), $key, true);
        $image = $value ? wp_get_attachment_image_url($value) : '';
        ob_start(); ?>
        <p class="form-field _<?= $this->type ?>_field" x-data="{ image_file: false, image_src: '<?= $image ?>' }">
            <label for="<?= $key ?>"><?= $this->name ?></label>
            <label style="width: 50%; box-sizing: border-box; margin: 0; float: none; cursor: pointer; padding: 1rem; border: 2px dashed #2271b1; display: block; border-radius: 4px;" for="<?= $key ?>">
                <input type="file" accept="image/*" style="display: none;" name="<?= $key ?>" id="<?= $key ?>" @change="image_file = $event.target.files > 0 ? $event.target.files[0] : false; image_src = (image_file ? URL.createObjectURL(image_file) : '')">
                <input type="hidden" :value="image_src" name="<?= $key ?>_src">
                <span x-text="image_src ? '' : 'Choose image'"></span>
                <span style="display: flex; gap: 1rem; align-items: center;">
                    <template x-cloak x-if="image_src">
                        <img style="width: 4rem; height: 4rem; object-fit: contain;" :src="image_src" alt="image_file ? image_file.name : ''" />
                    </template>
                </span>
            </label>

            <button type="reset" @click="image_file = false; image_src = ''" style="margin: 0.5rem 0 0; background-color: #ccc; border: 2px solid #ccc; padding: 0.25rem 0.75rem; border-radius: 4px; cursor: pointer;">Reset</button>
        </p>
        <?php echo ob_get_clean();
	}

	public function save($product_id, $parent=false)
	{
        if ( ! function_exists( 'wp_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        require_once( ABSPATH . 'wp-admin/includes/image.php' );

		$key = $parent . '_' . $this->slug;
        $src = $_POST[$key . "_src"];
        //TODO: Remove attachment if exists??
        if(!$src) {
            $attachment_id =  get_post_meta($product_id, $key, true);
            wp_delete_attachment($attachment_id, true);
            update_post_meta($product_id, $key, '');
            return;
        }

		if (isset($_FILES[$key])) { // phpcs:ignore
            $uploadedfile = $_FILES[$key];
            
            if($uploadedfile['size'] == 0) return false;
            $upload_overrides = ['test_form' => false];
            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
            
            if ( $movefile && ! isset( $movefile['error'] ) ) {
                // Create the "attachment" post, as seen on the media page
                $args = array(
                    'post_title' => $uploadedfile['name'],
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_mime_type' => $movefile['type'],
                );
                
                $attachment_id = wp_insert_attachment( $args, $movefile['file'] );
                
                // Abort if we could not insert the attachment
                // Also when aborted, delete the unattached file since it would not show up in the media gallery
                if ( is_wp_error( $attachment_id ) ) {
                    @unlink($movefile['file']);
                    return false;
                }

                update_post_meta($product_id, $key, $attachment_id); // phpcs:ignore
            } else {
                /*
                * Error generated by _wp_handle_upload()
                * @see _wp_handle_upload() in wp-admin/includes/file.php
                */
                echo $movefile['error'];
            }
		}
	}
}
