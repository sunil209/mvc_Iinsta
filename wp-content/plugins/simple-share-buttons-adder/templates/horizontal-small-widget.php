<ul>
<?php foreach( $template_data->buttons_array as $button ): ?>
	<li>
		<a rel="nofollow" target="_blank" href="<?php echo $button->share_link; ?>" class="<?php echo $button->class; ?>" data-site="<?php echo $button->name; ?>"></a>
	</li>
<?php endforeach; ?>
</ul>
