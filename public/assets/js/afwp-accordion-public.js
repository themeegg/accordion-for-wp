(function( $ ) {
	'use strict';

	var afwp_accordion={

		Snipits:{

			appendOnLoad: function(){
				if(!$('.afwp-accordion-template .menu-item-has-children .afwp-toggle-icon').length){
					$('.afwp-accordion-template .menu-item-has-children>a').after('<i class="afwp-toggle-icon"></i>');
				}
			},

			Horizontal:function(accordion_horizontal){

				if(!accordion_horizontal){
					accordion_horizontal = $('.afwp-accordion.horizontal');
				}
				accordion_horizontal = $('.afwp-accordion.horizontal');
				accordion_horizontal.each(function(){
					var itemsSelector, accordion_list_width, activeWidth, maxHeight= 0, afwp_title_width=0;
					itemsSelector = $(this).find('.afwp-accordion-item-wrap');
					itemsSelector.children('.afwp-content').css('height', '');
					itemsSelector.children('.afwp-accordion-title').css('height', '');
					itemsSelector.each(function(){
						maxHeight=(maxHeight>$(this).height()) ? maxHeight : $(this).height();
						afwp_title_width += $(this).children('.afwp-accordion-title').outerWidth()+2;
					});
					if(maxHeight){
						itemsSelector.children('.afwp-accordion-title').css('height', maxHeight);
						itemsSelector.children('.afwp-content').css('height', maxHeight);
					}
					accordion_list_width = $(this).find('.afwp-accordion-list').outerWidth();
					activeWidth = (accordion_list_width>afwp_title_width) ? accordion_list_width-afwp_title_width : 0;
					if(activeWidth){
						$(this).find('.afwp-content.current').css('width', activeWidth);
					}
				});

			},

			jsMenuAccordion: function($this){
				$this.toggleClass('slide-down').siblings('.sub-menu').slideToggle();
			},

		},

		Click: function(){

			$('.afwp_accordion_nav_menu').on('click', '.afwp-toggle-icon', function(evt){
				afwp_accordion.Snipits.jsMenuAccordion( $(this) );
			});

			$('.afwp-tab-list .afwp-post-link').click(function(evt){

				evt.preventDefault();

				var tab_list, tab_id, content_wraper;
				tab_id = $(this).attr('href');
				tab_list = $(this).closest('.afwp-tab-list');
				content_wraper = tab_list.siblings('.afwp-tab-content-wraper');

				$(this).toggleClass('current').closest('li').siblings('li').find('.afwp-post-link').removeClass('current');
				content_wraper.find(tab_id).siblings('.afwp-tab-content').removeClass('current');
				content_wraper.find(tab_id).addClass('current');

			});

			$('.afwp-accordion .afwp-accordion-title').click(function(evt){

				evt.preventDefault();
				var accordion_list, accordion_sibilings_list, accordion_wraper, accordion_wraper_width,
					accordion_title_width, afwp_content_width;
				accordion_list = $(this).closest('.afwp-accordion-item-wrap');
				accordion_sibilings_list= accordion_list.siblings('.afwp-accordion-item-wrap');
				accordion_wraper = $(this).closest('.afwp-accordion-list');

				if(accordion_wraper.hasClass('disabled')){
					return false;
				}else{
					accordion_wraper.addClass('disabled');
				}

				$(this).toggleClass('current');
				if($(this).closest('.afwp-accordion').hasClass('vertical')){
					$(this).siblings('.afwp-content').slideToggle().toggleClass('current');
					accordion_sibilings_list.find('.afwp-accordion-title').removeClass('current');
					accordion_sibilings_list.find('.afwp-content').slideUp().removeClass('current');
				}else{
					accordion_wraper_width = accordion_wraper.outerWidth();
					accordion_title_width = 0;
					accordion_wraper.find('.afwp-accordion-title').each(function(){
						accordion_title_width += $(this).outerWidth()+2;
					});
					afwp_content_width = (accordion_wraper_width>accordion_title_width) ? accordion_wraper_width - accordion_title_width : 0;

					accordion_sibilings_list.find('.afwp-accordion-title').removeClass('current');
					accordion_sibilings_list.find('.afwp-content').animate({width: 0}, 200, function(){ $(this).removeClass('current'); });
					if($(this).siblings('.afwp-content').hasClass('current')){
						$(this).siblings('.afwp-content').animate({width: 0}, 400, function(){ $(this).removeClass('current'); });
					}else{
						$(this).siblings('.afwp-content').addClass('current').animate({width: afwp_content_width});
					}

				}
				setTimeout(function(){
					afwp_accordion.Snipits.Horizontal(null);
					accordion_wraper.removeClass('disabled');
				}, 500);

			});

		},

		Ready: function(){
			afwp_accordion.Snipits.appendOnLoad();
			afwp_accordion.Snipits.Horizontal(null);
			afwp_accordion.Click();
		},

		Load: function(){

		},

		Resize: function(){
			afwp_accordion.Snipits.Horizontal(null);
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
