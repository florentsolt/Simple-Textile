<?php wp_nonce_field( "textile_toggle", "simpletextile_nonce"); ?>
<?php $toggle = get_post_meta($st_id, "textile", true); ?>
<? if (empty($toggle)) $toggle = 'true'; ?>
<input type="checkbox" name="simpletextile_toggle" id="simpletextile_toggle" value="true" <?php echo ($toggle == 'true' ? "checked='checked'" : "") ?> /> <label for="simpletextile_toggle">Process this post using Textile</label>
