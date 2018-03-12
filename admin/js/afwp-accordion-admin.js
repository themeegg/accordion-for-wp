(function( $ ) {
	'use strict';
	var afwp_accordion={

		Snipits: {

			Accordion_Widget: {

				Ajax_Data: function(accordion_data, append_to){
					var accordion_ajax_url = window.location.origin+ajaxurl;
					jQuery.post(accordion_ajax_url,{
							'action': 'afwp_accordion_widget',
							'data':   accordion_data
						},
						function(response){
							var change_html = afwp_accordion.Snipits.Accordion_Widget.Change_Widget_Data;
							change_html(append_to, response);
						}
					);
				},

				Change_Data: function(selector){
					var data, ajax_result,
						append_to=selector.data('accordion-change-id'),
						accordion_widget = afwp_accordion.Snipits.Accordion_Widget;
					data = {
						data_value: selector.val(),
						data_type: selector.data('accordion-value'),
					};
					accordion_widget.Ajax_Data(data, append_to);
				},

				Change_Widget_Data: function(append_to, ajax_result){
					var options, data_obj;
					data_obj=JSON.parse(ajax_result);
					options+='<option value="" selected="selected">No Filter</option>';
					$.each(data_obj, function(key, value){
						options+='<option value="'+value.slug+'">'+value.name+'</option>';
					});
					$(append_to).html(options);
					$(append_to).val('').trigger('change');
				},

			},

		},

		MouseEvents: function(){
			var _this=afwp_accordion, widget=_this.Snipits.Accordion_Widget;
			$(document).on('change', '.afwp-widget-post-type, .afwp-widget-taxonomy', function(evt){
				widget.Change_Data($(this));
			});
			$(document).on('click', '.afwp-tab-list .nav-tab', function(evt){
				evt.preventDefault();
				if($(this).hasClass('nav-tab-active')){
					return;
				}
				var tab_wraper, tab_id;
				tab_id = $(this).attr('href');
				tab_wraper = $(this).closest('.afwp-tab-wraper'); 
				$(this).addClass('nav-tab-active').siblings('.nav-tab').removeClass('nav-tab-active');
				tab_wraper.find('.afwp-tab-content').removeClass('afwp-content-active');
				tab_wraper.find(tab_id).addClass('afwp-content-active');
			});
		},

		Ready: function(){
			var _this=afwp_accordion;
			_this.MouseEvents();
		},

		Load: function(){
			var _this=afwp_accordion;

		},

		Scroll: function(){
			var _this=afwp_accordion;

		},

		Resize: function(){
			var _this=afwp_accordion;

		},

		Init: function(){
			var ready, load, scroll, resize, _this=afwp_accordion;
			ready=_this.Ready, load=_this.Load, resize=_this.Resize;
			$(document).ready(ready);
			$(window).load(load);
			$(window).resize(resize);
			$(window).scroll(scroll);
		}

	};

	afwp_accordion.Init();


})( jQuery );
