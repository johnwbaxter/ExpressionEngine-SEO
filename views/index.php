<h3><?=lang('seo_module_options_title')?></h3>
	
<?=form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=seo'.AMP.'method=update')?>
	
	<?=form_fieldset('Default Values')?>
		<p style="margin-bottom:15px;">
			<?=form_label(lang('default_title'), 'default_title')?> <?=form_input('default_title', $default_title, 'id="default_title"')?>
		</p>
		
		<p style="margin-bottom:15px;">
			<?=form_label(lang('default_keywords'), 'default_keywords')?> <?=form_input('default_keywords', $default_keywords, 'id="default_keywords"')?>
		</p>
		
		<p style="margin-bottom:15px;">
			<?=form_label(lang('default_description'), 'default_description')?> <?=form_textarea('default_description', $default_description, 'id="default_description"')?>
		</p>
	<?=	form_fieldset_close()?>
	
	<?=form_fieldset('Options')?>
		<p style="margin-bottom:15px;">
			<?=form_label(lang('prepend_to_title'), 'append')?> <?=form_input('prepend_to_title', $prepend_to_title, 'id="prepend"')?>
		</p>
		
		<p style="margin-bottom:15px;">
			<?=form_label(lang('append_to_title'), 'append')?> <?=form_input('append_to_title', $append_to_title, 'id="append"')?>
		</p>
			
		<p style="margin-bottom:15px;">
			<?=form_label(lang('robots'), 'robots')?><br />
	<?php
	//to do:  determine which are true and false based on options
	?>
			<?=form_radio('robots', 'noindex,nofollow', ($robots == 'noindex,nofollow') ? TRUE : FALSE, 'style="margin-bottom:3px;" id="noindexnofollow"')?> <?=form_label('<strong>Noindex, Nofollow</strong> - '.lang('most_private'), 'noindexnofollow')?><br />
			<?=form_radio('robots', 'noindex,follow', ($robots == 'noindex,follow') ? TRUE : FALSE, 'style="margin-bottom:3px;" id="noindexfollow"')?> <?=form_label('<strong>Noindex, Follow</strong>', 'noindexfollow')?><br />
			<?=form_radio('robots', 'index,nofollow', ($robots == 'index,nofollow') ? TRUE : FALSE, 'style="margin-bottom:3px;" id="indexnofollow"')?> <?=form_label('<strong>Index, Nofollow</strong>', 'indexnofollow')?><br />
			<?=form_radio('robots', 'index,follow', ($robots == 'index,follow') ? TRUE : FALSE, 'style="margin-bottom:3px;" id="indexfollow"')?> <?=form_label('<strong>Index, Follow</strong> - '.lang('least_private'), 'indexfollow')?>
		</p>
	<?=	form_fieldset_close()?>
	
	<p style="margin-bottom:15px;">
		<?=form_submit(array('name' => 'submit', 'value' => lang('submit'), 'class' => 'submit'))?>
	</p>

<?=form_close()?>