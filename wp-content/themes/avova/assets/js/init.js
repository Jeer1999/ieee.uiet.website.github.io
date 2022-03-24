/*
 * Copyright (c) 2021 Frenify
 * Author: Frenify
 * This file is made for CURRENT THEME
*/


/*

	@Author: Frenify
	@URL: https://frenify.com/


	This file contains the jquery functions for the actual theme, this
	is the file you need to edit to change the structure of the
	theme.

	This files contents are outlined below.

*/


var AvovaSiteurl 	= fn_avova_object.siteurl;
var AvovaPageLoader = jQuery('.avova_fn_pageloader');
var AvovaBody		= jQuery('body');
/* Page Preloader */
var t0 = performance.now();
window.addEventListener("load", function(){
	"use strict";
	if(AvovaPageLoader.length){
		var speed = parseFloat(AvovaPageLoader.data('speed'))*1000;
		var t1 = performance.now();
		if(t1-t0>speed){
			AvovaBody.addClass('preloader_loaded').removeClass('preloader_loading');
		}else{
			setTimeout(function(){AvovaBody.addClass('preloader_loaded').removeClass('preloader_loading');},speed-(t1-t0));
		}
	}
});


// All other theme functions
(function ($){

	"use strict";
	
    var AvovaInit 		= {
		
		
		pageNumber: 1,
		
        init: function () {
			this.cursor();
			this.minHeightForPages();
			this.url_fixer();
			this.textSkin();
			this.projectCategoryFitler();
			this.portfolioFilter();
			this.hamburgerOpener__Mobile();
			this.submenu__Mobile();
			this.openShare();
			this.imgToSVG();
			this.dataFnBgImg();
			this.estimateWidgetHeight();
			this.runPlayer();
			this.newPlayer();
			this.right_bar_opener();	
			this.categoryHook();	
			this.right_bar_height();
			this.toTopJumper();
			this.like();
			this.rating();
			this.recipe_video();
			this.search_opener();
			this.search_filter();
			this.fixedTotopScroll();
			this.prev_next_posts();
			this.widget__pages();
			this.widget__archives();
			this.dataFnStyle();
			this.portfolioContentHeight();
			this.inputCheckBoxInComment();
			this.inlineStyle();
			this.subscribe_form();
			this.addButtonToMenu();
        },
		
		
		addButtonToMenu: function(){
			var self		= this;
			var element 	= $('.menu-item-has-children');
			var count 		= element.length;
			var i			= 0;
			element.each(function(){
				$(this).children('a').append('<button></button');
				i++;if(i===count){self.addedButtonAction();}
			});
		},
		
		addedButtonAction: function(){
			var self		= this;
			$('.avova_fn_sidebar .navigation a').on('click',function(e){
				e.stopPropagation();
				var element = $(this);
				self.submenu__Mobile__init(element);
				if(element.siblings('.sub-menu').length){return false;}
			});
			$('.menu-item-has-children button').on('click',function(e){
				e.preventDefault();
				e.stopPropagation();
				var element = $(this);
				self.submenu__Mobile__init(element.closest('li').children('a'));
				return false;
			});
			$('.avova_fn_main_nav > li > a').focus(function(e){
				e.preventDefault();
				e.stopPropagation();
				var element = $(this);
			  	element.closest('li').siblings().removeClass('active').find('li').removeClass('active');
				element.closest('.avova_fn_main_nav').find('li').removeClass('active');
				element.closest('.avova_fn_main_nav').find('.sub-menu').slideUp();
		  	});
		},
		
		submenu__Mobile__init: function(element){
			var parent				= element.closest('li');
			var submenu				= element.siblings('.sub-menu');
			
			if(submenu.length){
				if(parent.hasClass('active')){
					parent.removeClass('active').find('.active').removeClass('active');
					parent.find('.sub-menu').slideUp();
				}else{
					var siblingActive	= parent.siblings('.active');
					if(siblingActive.length){
						siblingActive.removeClass('active').find('.active').removeClass('active');
						siblingActive.find('.sub-menu').slideUp();
					}
					submenu.slideDown();
					parent.addClass('active');
				}
				return false;
			}
		},
		
		
		subscribe_form: function(){
			$('.avova_fn_widget_subscribers a').on('click',function() {
				var e		= $(this);
				var p		= e.closest('.avova_fn_widget_subscribers');
				var m		= p.find('.message');
				var i		= p.find('input');
				var email	= i.val();
				m.removeClass('error success');
				if(e.hasClass('loading')){
					m.addClass('error').html(m.data('loading')).slideDown(500).delay(2000).slideUp(500);
					return false;
				}
				e.addClass('loading');
				// conditions
				if(email === ''){
					m.addClass('error').html(m.data('no-email')).slideDown(500).delay(2000).slideUp(500);
					e.removeClass('loading');
					return false;
				}
				
				var emailRegex	= /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				if(!emailRegex.test(email)){
					m.addClass('error').html(m.data('invalid-email')).slideDown(500).delay(2000).slideUp(500);
					e.removeClass('loading');
					return false;
				}
				
				var requestData = {
					action: 'avova_fn_subsribe__add_email',
					email: email
				};
				
				$.ajax({
					type: 'POST',
					url: fn_avova_object.ajax,
					cache: false,
					data: requestData,
					success: function(data) {
						var fnQueriedObj 	= $.parseJSON(data);
						var status			= fnQueriedObj.status;
						if(status === 'old'){
							m.addClass('success').html(m.data('old-email')).slideDown(500).delay(2000).slideUp(500);
							i.val('');
							e.removeClass('loading');
						}else if(status === 'new'){
							m.addClass('success').html(m.data('success')).slideDown(500).delay(2000).slideUp(500);
							i.val('');
							e.removeClass('loading');
						}else if(status === 'invalid_email'){
							m.addClass('error').html(m.data('invalid-email')).slideDown(500).delay(2000).slideUp(500);
							e.removeClass('loading');
							return false;
						}
					},
					error: function() {
						
					}
				});
				return false;
			 });	
		},
		
		inlineStyle: function(){
			var s = '';
			$('.avova_fn_style').each(function(){
				var e = $(this), v = e.val(); e.val(''); s+= v;
			});
			AvovaBody.append(s);
		},
		
		inputCheckBoxInComment: function(){
			if($('p.comment-form-cookies-consent input[type=checkbox]').length){
				$('p.comment-form-cookies-consent input[type=checkbox]').wrap('<label class="fn_checkbox"></label>').after('<span></span>');
			}
		},
		
		portfolioContentHeight: function(){
			var portfolio = $('.avova_fn_portfolio_page .portfolio_content');
			if(portfolio.height() === 0){
				portfolio.css({display: 'none'});
			}
		},
		
		dataFnStyle: function(){
			$('[data-fn-style]').each(function(){
				var el		= $(this);
				var s 		= el.attr('data-fn-style');
				$.each(s.split(';'),function(i,e){
					el.css(e.split(':')[0],e.split(':')[1]);
				});
			});
		},
		
		minHeightForPages: function(){
			var H 				= $(window).height(),
				W 				= $(window).width(),
				headerH 		= 0,
				mobileH 		= 0,
				adminBarH 		= 0,
				footerH 		= $('.avova_fn_footer').height(),
				mobile			= $('.avova_fn_mobilemenu_wrap'),
				header			= $('.avova_fn_header');
			if($('.avova-fn-wrapper').data('pos') === 'relative'){
				headerH 		= header.height();
			}
			if(mobile.css('display') !== 'none'){
				mobileH			= mobile.height();
				headerH			= 0;
			}
			if(AvovaBody.hasClass('admin-bar')){
				if(W<782){
					adminBarH	= 46;
				}else{
					adminBarH	= 32;
				}
			}
			$('.avova_fn_pages,.avova_fn_404').css({minHeight: (H-mobileH-headerH-footerH-adminBarH) + 'px'});	
		},
		
		url_fixer: function(){
			$('a[href*="fn_ex_link"]').each(function(){
				var oldUrl 	= $(this).attr('href'),
					array   = oldUrl.split('fn_ex_link/'),
					newUrl  = AvovaSiteurl + "/" + array[1];
				$(this).attr('href', newUrl);
			});
		},
		
		textSkin: function(){
			AvovaBody.addClass('fn__text_skin_'+$('.avova-fn-wrapper').data('text-skin'));
		},
		
		
		
		portfolioFilter: function(){
			var self					= this;
			$('.avova_fn_portfolio_page .fn_ajax_more a').off().on('click',function(){
				var thisButton 			= $(this);
				var more				= thisButton.closest('.fn_ajax_more');
				var input				= more.find('input');
				var abb					= thisButton.closest('.avova_fn_portfolio_page');
				var filter_page			= parseInt(input.val());
				if(thisButton.hasClass('active')){
					return false;
				}
				if(!abb.hasClass('go') && !more.hasClass('disabled')){
					abb.addClass('go');
					
					var requestData = {
						action: 'avova_fn_ajax_portfolio',
						filter_page: filter_page,
					};

					
					$.ajax({
						type: 'POST',
						url: fn_avova_object.ajax,
						cache: false,
						data: requestData,
						success: function(data) {
							console.log(data);
							var fnQueriedObj 	= $.parseJSON(data);
							var html			= fnQueriedObj.data;
							var $grid			= abb.find('.posts_list');
							var $items;
							$items = $(html);
							input.val(filter_page+1);
							input.change();
							
							if(fnQueriedObj.disabled === 'disabled'){
								more.addClass('disabled');
							}
							$grid.append( $items );
							if($().isotope){
								$grid.isotope( 'appended', $items );
								setTimeout(function(){
									$grid.isotope({
										itemSelector: 'li',
										masonry: {},
										stagger: 30
									});
								},500);
							}
								
							self.dataFnStyle();
							self.dataFnBgImg();
							abb.removeClass('go');
						},
						error: function(xhr, textStatus, errorThrown){
							abb.removeClass('go');
						}
					});
				}
					
				
				return false;
			});	
		},
		
		projectCategoryFitler: function(){
			if($().isotope){
				var items = $('.avova_fn_ajax_portfolio');
				items.each(function() {
					var thisItem 	= $(this);
					var list 		= thisItem.find('.posts_list');
					var filter 		= thisItem.find('.posts_filter');
					
					list.isotope({
					  	itemSelector: 'li',
						masonry: {},
						stagger: 30
					});

					// Isotope Filter 
					filter.find('a').off().on('click', function() {
						var selector = $(this).attr('data-filter');
						list = thisItem.find('.posts_list');
						filter.find('a').removeClass('current');
						$(this).addClass('current');
						list.isotope({
							filter: selector,
							animationOptions: {
								duration: 750,
								easing: 'linear',
								queue: false
							}
						});
						return false;
					});

				});
			}
			
		},
		
		cursor: function () {
			var myCursor = $('.frenify-cursor');
			if (myCursor.length) {
				if ($("body").length) {
					const e = document.querySelector(".cursor-inner"),
						t = document.querySelector(".cursor-outer");
					var n, i = 0,
						o = !1;
					var buttons = ".fn_cs_pricing_switcher .slider, .fn_cs_intro_testimonials .prev, .fn_cs_intro_testimonials .next, .fn_cs_swiper_nav_next, .fn_cs_swiper_nav_prev, .fn_dots, .swiper-button-prev, .swiper-button-next, .fn_cs_accordion .acc_head, .avova_fn_popupshare .share_closer, .avova_fn_header .fn_finder, .avova_fn_header .fn_trigger, a, input[type='submit'], .cursor-link, button";
					var sliders = ".owl-carousel, .swiper-container, .cursor-link";
					// link mouse enter + move
					window.onmousemove = function(s) {
						o || (t.style.transform = "translate(" + s.clientX + "px, " + s.clientY + "px)"), e.style.transform = "translate(" + s.clientX + "px, " + s.clientY + "px)", n = s.clientY, i = s.clientX
					}, $("body").on("mouseenter", buttons, function() {
						e.classList.add("cursor-hover"), t.classList.add("cursor-hover")
					}), $("body").on("mouseleave", buttons, function() {
						$(this).is("a") && $(this).closest(".cursor-link").length || (e.classList.remove("cursor-hover"), t.classList.remove("cursor-hover"))
					}), e.style.visibility = "visible", t.style.visibility = "visible";
					
					
					// slider mouse enter
					AvovaBody.on('mouseenter', sliders, function(){
						e.classList.add('cursor-slider');
						t.classList.add('cursor-slider');
					}).on('mouseleave', sliders,function(){
						e.classList.remove('cursor-slider');
						t.classList.remove('cursor-slider');
					});
					
					// slider mouse hold
					AvovaBody.on('mousedown', sliders, function(){
						e.classList.add('mouse-down');
						t.classList.add('mouse-down');
					}).on('mouseup', sliders, function(){
						e.classList.remove('mouse-down');
						t.classList.remove('mouse-down');
					});
				}
			}
		},
		
		
		widget__archives: function(){
			$('.widget_archive li').each(function(){
				var e = $(this);
				var a = e.find('a').clone();
				AvovaBody.append('<div class="frenify_hidden_item"></div>');
				$('.frenify_hidden_item').html(e.html());
				$('.frenify_hidden_item').find('a').remove();
				var suffix = $('.frenify_hidden_item').html().match(/\d+/); // 123456
				$('.frenify_hidden_item').remove();
				suffix = parseInt(suffix);
				if(isNaN(suffix)){
					return false;
				}
				suffix = '<span class="count">'+suffix+'</span>';
				e.html(a);
				e.append(suffix);
			});
		},
		
		prev_next_posts: function(){
			if($('.avova_fn_siblings')){
				$(document).keyup(function(e) {
					if(e.key.toLowerCase() === 'p') {
						var a = $('.avova_fn_siblings').find('a.previous_project_link');
						if(a.length){
							window.location.href = a.attr('href');
							return false;
						}
					}
					if(e.key.toLowerCase() === 'n') {
						var b = $('.avova_fn_siblings').find('a.next_project_link');
						if(b.length){
							window.location.href = b.attr('href');
							return false;
						}
					}
				});
			}
		},
		
		fixedTotopScroll: function(){
			var totop			= $('.avova_fn_totop');
			var height 			= parseInt(totop.find('input').val());
			if(totop.length){
				if($(window).scrollTop() > height){
					totop.addClass('scrolled');
				}else{
					totop.removeClass('scrolled');
				}
			}
		},
		
		search_placeholder: function(searchinput,text,i,speed){
			setTimeout(function(){
				searchinput.attr('placeholder',text);
			},i*speed);
		},
		
		search_opener: function(){
			var self		= this;
			var speed		= 10;
			var searchbox 	= $('.avova_fn_searchpopup');
			var opener 		= $('.fn_block_search .fn_finder, .avova_fn_header .fn_finder');
			var searchinput = $('.avova_fn_searchpopup input[type=text]');
			if(opener.length){
				opener.on('click',function(){
					if(AvovaBody.hasClass('open_search_popup')){
						searchbox.removeClass('focused');
						AvovaBody.removeClass('open_search_popup');
					}else{
						var placeholder = searchinput.attr('placeholder');
						searchinput.attr('placeholder','');
						var array 		= placeholder.split('');
						AvovaBody.addClass('open_search_popup');
						setTimeout(function(){
							var text = '';
							for(var i=0;i<array.length;i++){
								text+= array[i];
								self.search_placeholder(searchinput,text,i,speed);
							}
							setTimeout(function(){
								searchinput.focus();
								searchinput.trigger('click');
							},speed*array.length);
						},500);
					}
					return false;
				});
			}
			if(searchbox.length){
				var closer  	= searchbox.find('.search_closer,.extra_closer');
				var inputText  	= searchbox.find('input[type=text]');
				var inputSubmit	= searchbox.find('input[type=submit]');
				searchbox.find('.search_inner').on('click',function(){
					searchbox.removeClass('focused');
				});
				inputText.on('click',function(event){
					searchbox.addClass('focused');
					event.stopPropagation();
				});
				inputSubmit.on('click',function(event){
					event.stopPropagation();
				});
				closer.on('click',function(event){
					event.stopPropagation();
					searchbox.removeClass('focused');
					$('.avova_fn_header .fn_finder').focus();
					AvovaBody.removeClass('open_search_popup');
					closer.addClass('closed');
					setTimeout(function(){
						closer.removeClass('closed');
					},500);
				});
			}	
		},
		
		paginationFilter: function(){
			var self			= this;
			if($('.avova_fn_search_recipes').length){
				var pagination 	= $('.avova_fn_search_recipes .my_pagination a');
				pagination.off().on('click',function(){
					var el		= $(this);
					var li		= el.parent();
					if(!li.hasClass('current')){
						self.filterAjaxCall(el,el.html());
					}
					return false;
				});
			}
		},
		
		search_filter: function(){
			var self						= this;
			if($('.avova_fn_search_recipes').length){
				self.paginationFilter();
				var inputWrapper			= $('.avova_fn_search_recipes .input_wrapper');
				
				
				var textFilter				= $('.avova_fn_search_recipe_filter.text_filter');
				var textInput				= textFilter.find('input[type="text"]');
				
				var categoryFilter			= $('.avova_fn_search_recipe_filter.category_filter');
				var categoryPopup			= categoryFilter.find('.filter_popup_list');
				var categoryInput			= categoryFilter.find('input[type="text"]');
				var categoryHidden			= categoryFilter.find('input[type="hidden"]');
				var categoryNewValue		= categoryFilter.find('.new_value');
				var categoryPlaceholder		= categoryInput.attr('data-placeholder');
				var categoryType			= categoryInput.attr('data-type');
				
				var difficultyFilter		= $('.avova_fn_search_recipe_filter.difficulty_filter');
				var difficultyPopup			= difficultyFilter.find('.filter_popup_list');
				var difficultyInput			= difficultyFilter.find('input');
				var difficultyPlaceholder	= difficultyInput.attr('data-placeholder');
				var difficultyType			= difficultyInput.attr('data-type');
				
				var countryFilter			= $('.avova_fn_search_recipe_filter.country_filter');
				var countryPopup			= countryFilter.find('.filter_popup_list');
				var countryInput			= countryFilter.find('input');
				var countryPlaceholder		= countryInput.attr('data-placeholder');
				var countryType				= countryInput.attr('data-type');
				
				inputWrapper.on('click',function(){
					$('.avova_fn_search_recipes .filter_popup_list .item').show(); //added new
					$('.avova_fn_search_recipes .filter_popup_list .no_records').remove(); //added new
				});
				
				
				/************************/
				/* Filter by Text */
				/************************/
				var oldValue = textInput.val();
				var myVar 	= null;
				textInput.off().on('keyup', function(){
					var element		= $(this);
					if(element.val() === oldValue){
						return false;
					}
					if(element.val() === ''){
						textFilter.removeClass('ready filtered opened');
					}else{
						textFilter.addClass('ready filtered opened');
					}
					oldValue = element.val();
					clearTimeout(myVar);
					myVar = setTimeout(function(){ 
						self.filterAjaxCall(element);
					}, 700);
					return false;
				}).focusout(function() {
					textFilter.removeClass('opened');
				}).focus(function() {
					textFilter.addClass('opened');
				});
				
				/* remove filter */
				textFilter.find('.icon').off().on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					var el	= $(this);
					
					textInput.val(''); // added new
					textFilter.removeClass('ready filtered opened');
					
					self.filterAjaxCall(el);
				});
				
				/************************/
				/* Filter by Country */
				/************************/
				
				
				/* remove popup on window click */
				$(window).on('click',function(){
					countryFilter.removeClass('opened');
				});
				
				/* open popup on filter click */
				countryFilter.on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					difficultyFilter.removeClass('opened');
					categoryFilter.removeClass('opened');
					countryFilter.addClass('opened');
				});
				
				/* change placeholder to "Type Something" and backward */
				countryInput.focusout(function() {
					countryInput.attr('placeholder', countryPlaceholder);
				}).focus(function() {
					countryInput.attr('placeholder', countryType);
				});
				
				/* live search */
				countryInput.on('keyup', function(){
					var searchText 	= $(this).val().toUpperCase();
					var list 		= countryPopup.find('.filter_popup_list_in');
					var item 		= list.children('.item');
					var span, i, txtValue, counter=0;
					var norecord 	= list.find('.no_records');

					if(searchText !== ''){
						countryFilter.addClass('ready clear');
					}else{
						countryFilter.removeClass('ready clear');
					}
					for (i = 0; i < item.length; i++) {
						span 		= item[i].getElementsByTagName("span")[0];
						txtValue 	= span.textContent || span.innerText;
						if (txtValue.toUpperCase().indexOf(searchText) > -1) {
							item[i].style.display = "";
							counter--;
						} else {
							item[i].style.display = "none";
							counter++;
						}

					}
					if(counter === item.length && !norecord.length){
						list.append('<div class="no_records"><span>'+self.noRecords+'</span></div>');
					}else if(counter !== item.length){
						list.find('.no_records').remove();
					}

				});
				
				/* select function */
				countryPopup.find('.item').off().on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					var el 			= $(this);
					var statusName 	= el.data('name');

					if(!el.hasClass('sending')){
						el.addClass('sending');
						el.siblings().removeClass('sending');
						countryInput.attr('placeholder',''); // remove placeholder
						countryInput.val(statusName);
						countryFilter.addClass('ready'); // to enable reset button
						countryFilter.removeClass('opened');

						countryFilter.addClass('filtered');
						self.filterAjaxCall(el);
					}

					return false;
				});
				
				/* remove filter */
				countryFilter.find('.icon').off().on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					var el	= $(this);
					difficultyFilter.removeClass('opened');
					categoryFilter.removeClass('opened');
					
					countryInput.val(''); // added new
					countryPopup.find('.item').show(); //added new
					countryPopup.find('.no_records').remove(); // added new
					countryInput.attr('placeholder',countryPlaceholder);
					countryFilter.removeClass('ready');
					countryPopup.find('.item').removeClass('sending');
					countryFilter.removeClass('opened');
					countryFilter.removeClass('filtered');
					
					self.filterAjaxCall(el);
				});
				
				/************************/
				/* Filter by Difficulty */
				/************************/
				
				
				/* remove popup on window click */
				$(window).on('click',function(){
					difficultyFilter.removeClass('opened');
				});
				
				/* open popup on filter click */
				difficultyFilter.on('click',function(e){
					e.preventDefault();
					e.stopPropagation();

					categoryFilter.removeClass('opened');
					countryFilter.removeClass('opened');
					difficultyFilter.addClass('opened');
				});
				
				/* change placeholder to "Type Something" and backward */
				difficultyInput.focusout(function() {
					difficultyInput.attr('placeholder', difficultyPlaceholder);
				}).focus(function() {
					difficultyInput.attr('placeholder', difficultyType);
				});
				
				/* live search */
				difficultyInput.on('keyup', function(){
					var searchText 	= $(this).val().toUpperCase();
					var list 		= difficultyPopup.find('.filter_popup_list_in');
					var item 		= list.children('.item');
					var span, i, txtValue, counter=0;
					var norecord 	= list.find('.no_records');

					if(searchText !== ''){
						difficultyFilter.addClass('ready clear');
					}else{
						difficultyFilter.removeClass('ready clear');
					}
					for (i = 0; i < item.length; i++) {
						span 		= item[i].getElementsByTagName("span")[0];
						txtValue 	= span.textContent || span.innerText;
						if (txtValue.toUpperCase().indexOf(searchText) > -1) {
							item[i].style.display = "";
							counter--;
						} else {
							item[i].style.display = "none";
							counter++;
						}

					}
					if(counter === item.length && !norecord.length){
						list.append('<div class="no_records"><span>'+self.noRecords+'</span></div>');
					}else if(counter !== item.length){
						list.find('.no_records').remove();
					}

				});
				
				/* select function */
				difficultyPopup.find('.item').off().on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					var el 			= $(this);
					var statusName 	= el.data('name');

					if(!el.hasClass('sending')){
						el.addClass('sending');
						el.siblings().removeClass('sending');
						difficultyInput.attr('placeholder',''); // remove placeholder
						difficultyInput.val(statusName);
						difficultyFilter.addClass('ready'); // to enable reset button
						difficultyFilter.removeClass('opened');

						difficultyFilter.addClass('filtered');
						self.filterAjaxCall(el);
					}

					return false;
				});
				
				/* remove filter */
				difficultyFilter.find('.icon').off().on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					var el	= $(this);
					countryFilter.removeClass('opened');
					categoryFilter.removeClass('opened');
					
					difficultyInput.val(''); // added new
					difficultyPopup.find('.item').show(); //added new
					difficultyPopup.find('.no_records').remove(); // added new
					difficultyInput.attr('placeholder',difficultyPlaceholder);
					difficultyFilter.removeClass('ready');
					difficultyPopup.find('.item').removeClass('sending');
					difficultyFilter.removeClass('opened');
					difficultyFilter.removeClass('filtered');
					
					self.filterAjaxCall(el);
				});
				
				
				
				
				
				/**********************/
				/* Filter by Category */
				/**********************/
				
				
				/* remove popup on window click */
				$(window).on('click',function(){
					categoryFilter.removeClass('opened');
				});
				
				/* open popup on filter click */
				categoryFilter.on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					difficultyFilter.removeClass('opened');
					countryFilter.removeClass('opened');
					categoryFilter.addClass('opened');
					categoryInput.focus();
				});
				
				/* change placeholder to "Type Something" and backward */
				categoryInput.focusout(function() {
					if(categoryNewValue.html() === ''){
						categoryInput.attr('placeholder', categoryPlaceholder);
					}else{
						categoryInput.attr('placeholder', '');
					}
					
				}).focus(function() {
					categoryInput.attr('placeholder', categoryType);
				});
				
				/* live search */
				categoryInput.on('keyup', function(){
					var searchText 	= $(this).val().toUpperCase();
					var list 		= categoryPopup.find('.filter_popup_list_in');
					var item 		= list.children('.item');
					var span, i, txtValue, counter=0;
					var norecord 	= list.find('.no_records');

					if(searchText !== ''){
						categoryFilter.addClass('ready clear');
					}else{
						categoryFilter.removeClass('ready clear');
					}
					for (i = 0; i < item.length; i++) {
						span 		= item[i].getElementsByTagName("span")[0];
						txtValue 	= span.textContent || span.innerText;
						if (txtValue.toUpperCase().indexOf(searchText) > -1) {
							item[i].style.display = "";
							counter--;
						} else {
							item[i].style.display = "none";
							counter++;
						}

					}
					if(counter === item.length && !norecord.length){
						list.append('<div class="no_records"><span>'+self.noRecords+'</span></div>');
					}else if(counter !== item.length){
						list.find('.no_records').remove();
					}

				});
				
				/* select function */
				categoryPopup.find('.item').off().on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					var el 			= $(this);
					var statusName 	= el.data('name');
					var array = [],newvalue = '';
					
					if(categoryHidden.val() !== ''){
						array = categoryHidden.val().split(',');
					}

					categoryInput.val('');
					categoryPopup.find('.item').show();
					categoryPopup.find('.no_records').remove();
					categoryInput.attr('placeholder','');
					categoryInput.bind('click');
					
					if(!el.hasClass('sending')){
						el.addClass('sending');
						array.push(statusName);
					}else{
						el.removeClass('sending');
						var index = array.indexOf(statusName);
						if (index > -1) {
							array.splice(index, 1);
						}
					}
					categoryHidden.val(array.join(','));
					categoryHidden.triggerHandler("change");
					if(array.length){
						categoryFilter.addClass('ready'); // to enable reset button
						categoryFilter.addClass('filtered');
						newvalue += ''+array[0];
						if(array.length > 1){
							newvalue += ', + ' + (array.length - 1);
						}
					}else{
						categoryFilter.removeClass('ready'); // to disable reset button
						categoryFilter.removeClass('filtered');
					}
					categoryNewValue.html(newvalue);
					categoryInput.focus();
					self.filterAjaxCall(el);

					return false;
				});
				
				/* remove filter */
				categoryFilter.find('.icon').off().on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					var el	= $(this);
					difficultyFilter.removeClass('opened');
					countryFilter.removeClass('opened');
					
					categoryHidden.val('');
					categoryHidden.triggerHandler("change");
					categoryInput.val(''); // added new
					categoryNewValue.html('');
					categoryPopup.find('.item').show(); //added new
					categoryPopup.find('.no_records').remove(); // added new
					categoryInput.attr('placeholder',categoryPlaceholder);
					categoryFilter.removeClass('ready');
					categoryPopup.find('.item').removeClass('sending');
					categoryFilter.removeClass('opened');
					categoryFilter.removeClass('filtered');
					
					self.filterAjaxCall(el);
				});
			}
		},
		getQueryVariable: function(url, variable) {
			var query = url.substring(1);
			var vars = query.split('&');
			for (var i=0; i<vars.length; i++) {
				var pair = vars[i].split('=');
				if (pair[0] === variable) {
					return pair[1];
				}
			}

			return false;
		},
		filterAjaxCall: function(element,filter_page){
			var pagination = true;
			if ( typeof filter_page === 'undefined') {
			  	filter_page			= 1;
			  	pagination			= false;
			}
			var parent = element.closest('.avova_fn_search_recipes');
			if(parent.hasClass('loading')){
				return false;
			}
			var self					= this;
			var filter_difficulty		= '*';
			var filter_country			= '*';
			var filter_category_array	= '';
			filter_category_array 		= parent.find('.category_filters').val();
			if(parent.find('.filter_popup_list.difficulty div.sending').length){
				filter_difficulty		= parent.find('.filter_popup_list.difficulty .sending').data('filter');
			}
			if(parent.find('.filter_popup_list.country div.sending').length){
				filter_country			= parent.find('.filter_popup_list.country .sending').data('filter');
			}
			var search_term 			= parent.find('.text_filter input').val();
			var requestData = {
				action: 'avova_fn_search_filter',
				filter_category_array: filter_category_array,
				filter_difficulty: filter_difficulty,
				filter_country: filter_country,
				filter_page: filter_page,
				search_term: search_term,
			};
			


			$.ajax({
				type: 'POST',
				url: fn_avova_object.ajax,
				cache: false,
				data: requestData,
				success: function(data) {
					var fnQueriedObj 	= $.parseJSON(data);
					var html			= fnQueriedObj.avova_fn_data;
					parent.find('.post_section_in').html(html);
					self.dataFnBgImg();
					self.imgToSVG();
					self.like();
					parent.removeClass('loading');
					
					var speed		= 800;
					if(!pagination){
						speed 		= 0;
					}
					var listItem 	= parent.find('.my_list ul > li');
					if(listItem.length){
						setTimeout(function(){
							listItem.each(function(i, e){
								setTimeout(function(){
									$(e).addClass('fadeInTop done');
								}, (i*100));	
							});
						}, speed+100);
					}else{
						parent.find('.fn_animated').addClass('fadeInTop done');
					}
					if(pagination){
						$([document.documentElement, document.body]).animate({
							scrollTop: parent.offset().top
						}, speed);
					}
						
					self.paginationFilter();
				},
				error: function(xhr, textStatus, errorThrown){
					console.log(errorThrown);
					console.log(textStatus);
					console.log(xhr);
				}
			});
		},
		
		right_bar_opener: function(){
			var hamburger 	= $('.avova_fn_header .fn_trigger,.fn_block_trigger a');hamburger.addClass('ready');
			var trigger 	= $('.avova_fn_right_panel .extra_closer, .avova_fn_right_panel .fn_closer');
			trigger.on('click',function(){
				AvovaBody.toggleClass('fn_opened');
				return false;
			});
			hamburger.on('click',function(){
				AvovaBody.addClass('fn_opened');
				return false;
			});
			var i = null;
			hamburger.on('mouseenter',function(){
				i = setTimeout(function(){
					AvovaBody.addClass('fn_opened');
				},700);
			}).on('mouseleave',function(){
				clearTimeout(i);
			});
		},
		
		categoryHook: function(){
			var self = this;
			var list = $('.wp-block-archives li, .widget_avova_custom_categories li, .widget_categories li, .widget_archive li');
			list.each(function(){
				var item = $(this);
				if(item.find('ul').length){
					item.addClass('has-child');
				}
			});
			
			
			var html = $('.avova_fn_hidden.more_cats').html();
			var cats = $('.widget_categories,.widget_archive,.widget_avova_custom_categories');
			if(cats.length){
				cats.each(function(){
					var element = $(this);
					var limit	= 3;
					element.append(html);
					var li = element.find('ul:not(.children) > li');
					if(li.length > limit){
						var h = 0;
						li.each(function(i,e){
							if(i < limit){
								h += $(e).outerHeight(true,true);
							}else{
								return false;
							}
						});
						element.find('ul:not(.children)').css({height: h + 'px'});
						element.find('.avova_fn_more_categories .fn_count').html('('+(li.length-limit)+')');
					}else{
						element.addClass('all_active');
					}
				});
				self.categoryHookAction();
			}
		},
		
		categoryHookAction: function(){
			var self			= this;
			$('.avova_fn_more_categories').find('a').off().on('click',function(){
				var e 			= $(this);
				var limit		= 3;
				var myLimit		= limit;
				var parent 		= e.closest('.widget_block');
				var li 			= parent.find('ul:not(.children) > li');
				var liHeight	= li.outerHeight(true,true);
				var h			= liHeight*limit;
				var liLength	= li.length;
				var speed		= (liLength-limit)*50;
				e.toggleClass('show');
				if(e.hasClass('show')){
					myLimit		= liLength;
					h			= liHeight*liLength;
					e.find('.text').html(e.data('less'));
					e.find('.fn_count').html('');
				}else{
					e.find('.text').html(e.data('more'));
					e.find('.fn_count').html('('+(liLength-limit)+')');
				}
				
				
				var H = 0;
				li.each(function(i,e){
					if(i < myLimit){
						H += $(e).outerHeight(true,true);
					}else{
						return false;
					}
				});
				
				speed = (speed > 300) ? speed : 300;
				speed = (speed < 1500) ? speed : 1500;
				parent.find('ul:not(.children)').animate({height:H},speed);
				
				setTimeout(function(){
					self.right_bar_height();
				},(speed+1));
				
				
				return false;
			});
		},
		
		recipe_video: function(){
			$('.avova_fn_single_recipe .popup-youtube').each(function() { // the containers for all your galleries
				$(this).magnificPopup({
					disableOn: 700,
					type: 'iframe',
					mainClass: 'mfp-fade',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false
				});
			});
		},
		
		rating: function(){
			var radio 	= $('.comments-rating input[type="radio"]');
			radio.on('click',function(){
				var el 	= $(this);
				var id	= el.attr('id');
				$('.comments-rating .fn_radio').removeClass('clicked');
				$('.comments-rating .'+id).addClass('clicked');
		 	}).on('mouseenter',function(){
				var el 	= $(this);
				var id	= el.attr('id');
				$('.comments-rating .fn_radio').removeClass('hovered');
				$('.comments-rating .'+id).addClass('hovered');
		 	}).on('mouseleave',function(){
				$('.comments-rating .fn_radio').removeClass('hovered');
		 	});
		},
		
		
		
		
		
		
		
		right_bar_height: function(){
			var H		= $(window).height(),
				bar		= $('.avova_fn_popup_sidebar'),
				inner	= bar.find('.sidebar_wrapper');
			bar.height(H + 'px');
			if($().niceScroll){
				inner.getNiceScroll().remove();
				inner.height('100%').niceScroll({
					touchbehavior: false,
					cursorwidth: 0,
					autohidemode: true,
					cursorborder: "0px solid #e5e5e5"
				});
			}
		},
		
		
		toTopJumper: function(){
			var totop		= $('.avova_fn_footer .footer_totop a,a.avova_fn_totop,.avova_fn_footer .footer_right_totop a,.fn_block_totop a');
			if(totop.length){
				totop.on('click', function(e) {
					e.preventDefault();		
					$("html, body").animate(
						{ scrollTop: 0 }, 'slow');
					return false;
				});
			}
		},
		
		
		
		runPlayer: function(){
			var parent		= $('.avova_fn_main_audio');
			var audioVideo 	= parent.find('audio,video');
			audioVideo.each(function(){
				var element = $(this);
				element.mediaelementplayer({
					// Do not forget to put a final slash (/)
					pluginPath: 'https://cdnjs.com/libraries/mediaelement/',
					// this will allow the CDN to use Flash without restrictions
					// (by default, this is set as `sameDomain`)
					shimScriptAccess: 'always',
					success: function(mediaElement, domObject) {
						mediaElement.addEventListener('play', function() {
							parent.removeClass('fn_pause').addClass('fn_play');
						}, false);
						mediaElement.addEventListener('pause', function() {
							parent.removeClass('fn_play').addClass('fn_pause');
						}, false);
					},
				});
			});
		},
		
		newPlayer: function(){
			var parent		= $('.avova_fn_main_audio');
			var closer 	  	= parent.find('.fn_closer');
			var audioVideo 	= parent.find('audio,video');
			var icon 		= parent.find('.podcast_icon');
			var audios		= $('.avova_fn_audio_button');
			var playButton	= $('.avova_fn_audio_button a');
			var self		= this;
			audioVideo.each(function(){
				var element = $(this);
				element.mediaelementplayer({
					// Do not forget to put a final slash (/)
					pluginPath: 'https://cdnjs.com/libraries/mediaelement/',
					// this will allow the CDN to use Flash without restrictions
					// (by default, this is set as `sameDomain`)
					shimScriptAccess: 'always',
					success: function(mediaElement, domObject) {
						mediaElement.addEventListener('pause', function() {
							parent.removeClass('fn_play').addClass('fn_pause');
						}, false);
						mediaElement.addEventListener('play', function() {
							parent.removeClass('fn_pause').addClass('fn_play');
						}, false);
					},
				});
			});
			closer.off().on('click', function(){
				if(parent.hasClass('closed')){
					parent.removeClass('closed');
					closer.find('span').html(closer.attr('data-close-text'));
				}else{
					parent.addClass('closed');
					closer.find('span').html(closer.attr('data-open-text'));
				}
			});
			icon.off().on('click', function(){
				if(parent.find('audio,video').length){
					if(parent.hasClass('fn_pause')){
						parent.removeClass('fn_pause').addClass('fn_play').find('audio,video')[0].play();
					}else{
						parent.removeClass('fn_play').addClass('fn_pause').find('audio,video')[0].pause();
					}
				}
			});
			playButton.off().on('click',function(){
				var button		= $(this);
				var wrapper		= button.parent();
				if(!wrapper.hasClass('active')){
					audios.removeClass('active fn_play fn_pause');
					wrapper.addClass('active');
				}
				if(wrapper.hasClass('fn_pause')){
					wrapper.removeClass('fn_pause').addClass('fn_play');
					parent.find('audio,video')[0].play();
				}else if(wrapper.hasClass('fn_play')){
					wrapper.removeClass('fn_play').addClass('fn_pause');
					parent.find('audio,video')[0].pause();
				}else{
					wrapper.addClass('fn_play');
					var src			= wrapper.attr('data-mp3');
					var audio	 	= '<audio controls><source src="'+src+'" type="audio/mpeg"></audio>';
					$('.avova_fn_main_audio .audio_player').html(audio);
					self.runPlayer();
					setTimeout(function(){
						parent.find('audio,video')[0].play();
						parent.removeClass('fn_pause').addClass('fn_play');
						parent.removeClass('closed');
						closer.find('span').html(closer.attr('data-close-text'));
						self.playerSpace();
					},50);
				}
				
				return false;
			});
		},
		
		
		
		openShare: function(){
			var btn 		= $('.avova_fn_sharebox a');
			var sharebox	= $('.avova_fn_popupshare');
			btn.off().on('click',function(){
				var element = $(this),
					parent	= element.closest('.avova_fn_sharebox');
				var box		= parent.find('.share_hidden_box'),
					title	= box.find('.hidden_title').html(),
					heading	= box.find('.hidden_share').html(),
					list	= box.find('ul').html();
				sharebox.find('.share_header').html(heading);
				sharebox.find('.share_title').html(title);
				sharebox.find('.share_list ul').html(list);
				sharebox.addClass('opened');
				parent.addClass('opened');
				return false;
			});
			var closer		= $('.avova_fn_popupshare .share_closer');
			closer.off().on('click',function(){
				btn.removeClass('opened');
				sharebox.removeClass('opened');
				return false;
			});
		},
		
		widget__pages: function(){
			var nav 						= $('.widget_pages ul');
			nav.each(function(){
				$(this).find('a').off().on('click', function(e){
					var element 			= $(this);
					var parentItem			= element.parent('li');
					var parentItems			= element.parents('li');
					var parentUls			= parentItem.parents('ul.children');
					var subMenu				= element.next();
					var allSubMenusParents 	= nav.find('li');

					allSubMenusParents.removeClass('opened');

					if(subMenu.length){
						e.preventDefault();

						if(!(subMenu.parent('li').hasClass('active'))){
							if(!(parentItems.hasClass('opened'))){parentItems.addClass('opened');}

							allSubMenusParents.each(function(){
								var el = $(this);
								if(!el.hasClass('opened')){el.find('ul.children').slideUp();}
							});

							allSubMenusParents.removeClass('active');
							parentUls.parent('li').addClass('active');
							subMenu.parent('li').addClass('active');
							subMenu.slideDown();


						}else{
							subMenu.parent('li').removeClass('active');
							subMenu.slideUp();
						}
						return false;
					}
				});
			});
		},
		
		submenu__Mobile: function(){
			var self						= this;
			$('.vert_menu_list a, .widget_nav_menu .menu a').on('click', function(){
				var element 			= $(this);
				self.submenu__Mobile__init(element);
				return false;
			});
		},
		
		hamburgerOpener__Mobile: function(){
			var hamburger		= $('.avova_fn_mobilemenu_wrap .hamburger');
			hamburger.on('click',function(){
				var element 	= $(this);
				var menupart	= $('.avova_fn_mobilemenu_wrap .mobilemenu');
				if(element.hasClass('is-active')){
					element.removeClass('is-active');
					menupart.removeClass('opened');
					menupart.slideUp(500);
				}else{
					element.addClass('is-active');
					menupart.addClass('opened');
					menupart.slideDown(500);
				}return false;
			});
		},
		
		like: function(){
			var svg;
			var self	= this;
			if($('.avova-fn-wrapper').length){
				svg = $('.avova-fn-wrapper').data('like-url');
			}
			var ajaxRunningForLike = false;
			$('.avova_fn_like').off().on('click', function(e) {
				e.preventDefault();

				var likeLink 		= $(this),
					ID 				= $(this).data('id'),
					likeAction,addAction;
				
				likeLink 			= $('.avova_fn_like[data-id="'+ID+'"]');

				if(ajaxRunningForLike === true) {return false;}
				
				if(likeLink.hasClass('liked')){
					likeAction 		= 'liked';
					addAction		= 'not-rated';
				}else{
					likeAction 		= 'not-rated';
					addAction		= 'liked';
				}
				ajaxRunningForLike 	= true;
				
				var requestData 	= {
					action: 'avova_fn_like', 
					ID: ID,
					likeAction: likeAction
				};
				
				$.ajax({
					type: 'POST',
					url: fn_avova_object.ajax,
					cache: false,
					data: requestData,
					success: function(data) {
						var fnQueriedObj 	= $.parseJSON(data); //get the data object
						likeLink.removeClass('animate ' + likeAction).addClass(addAction);
						likeLink.find('.avova_w_fn_svg').remove();
						likeLink.find('.avova_fn_like_count').before('<img src="'+fnQueriedObj.svg+'" class="avova_w_fn_svg" alt="" />');
						self.imgToSVG();
						likeLink.find('.count').html(fnQueriedObj.count);
						likeLink.find('.text').html(fnQueriedObj.like_text);
						likeLink.attr('title',fnQueriedObj.title);
						likeLink.addClass('animate');
						ajaxRunningForLike = false;
					},
					error: function(MLHttpRequest, textStatus, errorThrown) {
						console.log(MLHttpRequest);
						console.log(textStatus);
						console.log(errorThrown);
					}
				});	

				return false;
			});
		},
		
		
		imgToSVG: function(){
			$('img.avova_fn_svg,img.avova_w_fn_svg').each(function(){
				var img 		= $(this);
				var imgClass	= img.attr('class');
				var imgURL		= img.attr('src');

				$.get(imgURL, function(data) {
					var svg 	= $(data).find('svg');
					if(typeof imgClass !== 'undefined') {
						svg 	= svg.attr('class', imgClass+' replaced-svg');
					}
					img.replaceWith(svg);

				}, 'xml');

			});	
		},
		
		
		dataFnBgImg: function(){
			var bgImage 	= $('*[data-fn-bg-img]');
			bgImage.each(function(){
				var element = $(this);
				var attrBg	= element.attr('data-fn-bg-img');
				var bgImg	= element.data('fn-bg-img');
				if(typeof(attrBg) !== 'undefined'){
					element.addClass('frenify-ready').css({backgroundImage:'url('+bgImg+')'});
				}
			});
		},
		
		
		estimateWidgetHeight: function(){
			var est 	= $('.avova_fn_widget_estimate');
			est.each(function(){
				var el 	= $(this);
				var h1 	= el.find('.helper1');
				var h2 	= el.find('.helper2');
				var h3 	= el.find('.helper3');
				var h4 	= el.find('.helper4');
				var h5 	= el.find('.helper5');
				var h6 	= el.find('.helper6');
				var eW 	= el.outerWidth();
				var w1 	= Math.floor((eW * 80) / 300);
				var w2 	= eW-w1;
				var e1 	= Math.floor((w1 * 55) / 80);
				h1.css({borderLeftWidth:	w1+'px', borderTopWidth: e1+'px'});
				h2.css({borderRightWidth:	w2+'px', borderTopWidth: e1+'px'});
				h3.css({borderLeftWidth:	w1+'px', borderTopWidth: w1+'px'});
				h4.css({borderRightWidth:	w2+'px', borderTopWidth: w1+'px'});
				h5.css({borderLeftWidth:	w1+'px', borderTopWidth: w1+'px'});
				h6.css({borderRightWidth:	w2+'px', borderTopWidth: w1+'px'});
			});
		},
    };
	
	
	
	// ready functions
	$(document).ready(function(){
		AvovaInit.init();
	});
	
	// resize functions
	$(window).on('resize',function(e){
		e.preventDefault();
		AvovaInit.projectCategoryFitler();
		AvovaInit.right_bar_height();
		AvovaInit.estimateWidgetHeight();
	});
	
	// scroll functions
	$(window).on('scroll', function(e) {
		e.preventDefault();
		AvovaInit.fixedTotopScroll();
    });
	
	// load functions
	$(window).on('load', function(e) {
		e.preventDefault();
		AvovaInit.projectCategoryFitler();
		setTimeout(function(){
			AvovaInit.projectCategoryFitler();
		},100);
	});
	
})(jQuery);


// add all the elements inside modal which you want to make focusable
var focusableElements 		= 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
var modal 					= document.querySelector('.avova_fn_searchpopup'); // select the modal by it's id or class
if(modal){
	var firstFocusableElement 	= modal.querySelectorAll(focusableElements)[0]; // get first element to be focused inside modal
	var focusableContent 		= modal.querySelectorAll(focusableElements);
	var lastFocusableElement 	= focusableContent[focusableContent.length - 1]; // get last element to be focused inside modal


	document.addEventListener('keydown', function(e) {
		"use strict";
		var isTabPressed = e.key === 'Tab' || e.keyCode === 9;

		if (!isTabPressed) {return;}
		if (e.shiftKey) { // if shift key pressed for shift + tab combination
			if (document.activeElement === firstFocusableElement) {
				lastFocusableElement.focus(); // add focus for the last focusable element
				e.preventDefault();
			}
		} else { // if tab key is pressed
			if (document.activeElement === lastFocusableElement) { // if focused has reached to last focusable element then focus first focusable element after pressing tab
				firstFocusableElement.focus(); // add focus for the first focusable element
				e.preventDefault();
			}
		}
	});

	//firstFocusableElement.focus();
}



//var modal2 					= document.querySelector('.avova_fn_mobilemenu_wrap');
//if(modal2){
//	var firstFocusableElement2 	= modal2.querySelectorAll(focusableElements)[0];
//	var focusableContent2 		= modal2.querySelectorAll(focusableElements);
//	var lastFocusableElement2 	= focusableContent2[focusableContent2.length - 1]; // get last element to be focused inside modal
//
//
//	document.addEventListener('keydown', function(e) {
//		"use strict";
//		var isTabPressed = e.key === 'Tab' || e.keyCode === 9;
//
//		if (!isTabPressed) {return;}
//
//		if (e.shiftKey) { // if shift key pressed for shift + tab combination
//			if (document.activeElement === firstFocusableElement2) {
//				lastFocusableElement2.focus(); // add focus for the last focusable element
//				e.preventDefault();
//			}
//		} else { // if tab key is pressed
//			if (document.activeElement === lastFocusableElement2) { // if focused has reached to last focusable element then focus first focusable element after pressing tab
//				firstFocusableElement2.focus(); // add focus for the first focusable element
//				e.preventDefault();
//			}
//		}
//	});
//
//	if(firstFocusableElement2){
//		firstFocusableElement2.focus();
//	}
//}