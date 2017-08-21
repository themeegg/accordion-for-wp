(function( $ ) {
	'use strict';

	var afwp_accordion={

		Snipits:{

			appendOnLoad: function(){

				if(!$('.afwp-accordion-template .menu-item-has-children .afwp-toggle-icon').length){
					$('.afwp-accordion-template .menu-item-has-children>a').after('<i class="afwp-toggle-icon"></i>');
				}

			},

			Horizontal:function(){
				var itemsSelector, maxHeight=0;
				itemsSelector = $('.afwp-accordion.horizontal .afwp-accordian-item-wrap');
				itemsSelector.children('label').removeAttr('style');
				itemsSelector.children('afwp-content').removeAttr('style');
				itemsSelector.each(function(){
					maxHeight=(maxHeight>$(this).height()) ? maxHeight : $(this).height();
				});
				if(maxHeight){
					itemsSelector.children('label').css('height', maxHeight);
					itemsSelector.children('.afwp-content').css('height', maxHeight);
				}
			},

			jsMenuAccordion: function($this){
				$this.toggleClass('slide-down').siblings('.sub-menu').slideToggle();
			},

		},

		Click: function(){
			$('.afwp-accordion-template').on('click', '.afwp-toggle-icon', function(evt){
				afwp_accordion.Snipits.jsMenuAccordion( $(this) );
			});
		},

		Ready: function(){
			afwp_accordion.Snipits.appendOnLoad();
			afwp_accordion.Snipits.Horizontal();
			afwp_accordion.Click();
		},

		Load: function(){

		},

		Resize: function(){

		},

		Scroll: function(){

		},

		Init: function(){

			var ready, load, resize, scroll, _this=afwp_accordion;
			ready=_this.Ready, load=_this.Load, resize=_this.Resize;

			$(document).ready(ready);
			$(window).load(load);
			$(window).resize(resize);
			$(window).scroll(scroll);

		}
	};

	afwp_accordion.Init();

})( jQuery );
