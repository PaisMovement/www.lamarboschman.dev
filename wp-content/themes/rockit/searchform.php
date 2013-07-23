<form method="get" action="<?php echo home_url()?>" id="searchform" role="search">
    <input name="s" id="s" value="<?php _e('Search for:', CSDOMAIN); ?>"
    onfocus="if(this.value=='<?php _e('Search for:', CSDOMAIN); ?>') {this.value='';}"
    onblur="if(this.value=='') {this.value='<?php _e('Search for:', CSDOMAIN); ?>';}" type="text" class="bar" />
    <input type="submit" id="searchsubmit" onclick="remove_text('<?php _e('Search for:', CSDOMAIN); ?>')" value="<?php _e('Search', CSDOMAIN); ?>" class="backcolr" />
</form>
