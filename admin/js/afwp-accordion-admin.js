(function( $ ) {
	'use strict';
	var dg_accordion={

		Snipits: {

			Accordion_Widget: {

				Ajax_Data: function(accordion_data, append_to){
					var accordion_ajax_url = window.location.origin+ajaxurl;
					jQuery.post(accordion_ajax_url,{
							'action': 'afwp_accordion_widget',
							'data':   accordion_data
						},
						function(response){
							var change_html = dg_accordion.Snipits.Accordion_Widget.Change_Widget_Data;
							change_html(append_to, response);
						}
					);
				},

				Change_Data: function(selector){
					var data, ajax_result,
						append_to=selector.data('accordion-change-id'),
						accordion_widget = dg_accordion.Snipits.Accordion_Widget;
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
			var _this=dg_accordion, widget=_this.Snipits.Accordion_Widget;
			$('.afwp-widget-post-type, .afwp-widget-taxonomy').on('change', function(evt){
				widget.Change_Data($(this));
			});
		},

		Ready: function(){
			var _this=dg_accordion;
			_this.MouseEvents();
		},

		Load: function(){
			var _this=dg_accordion;

		},

		Scroll: function(){
			var _this=dg_accordion;

		},

		Resize: function(){
			var _this=dg_accordion;

		},

		Init: function(){
			var ready, load, scroll, resize, _this=dg_accordion;
			ready=_this.Ready, load=_this.Load, resize=_this.Resize;
			$(document).ready(ready);
			$(window).load(load);
			$(window).resize(resize);
			$(window).scroll(scroll);
		}

	};

	dg_accordion.Init();


})( jQuery );