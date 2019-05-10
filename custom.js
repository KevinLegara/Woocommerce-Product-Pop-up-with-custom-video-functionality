$(document).ready(function(){
	var valueZero = $(".search-submit").val('');
	var windowSize = $(window).width();
	if (valueZero) {
		if (windowSize <= 1366) {
			$(".search-field").attr("placeholder", "Search...");
		}else{
			$(".search-field").attr("placeholder", "Search Health Blueprints, Recipes and More...");
		}
	}

	var c=0, n=$('.headerSayings').length;
	var visibleTime  = 5000;
	var hiddenTime   = 500;
	
	function loop(){
	    $('.headerSayings').hide().eq(c++%n).stop().delay(hiddenTime).fadeTo(100,1,function(){
	        $(this).delay(visibleTime).fadeTo(100,0,loop);
	    });
	    $(".headerSayings").css("opacity", "1");
	    $(".headerTopMember").css("height", "auto");
	    $(".headerTopMember").css("overflow", "unset");
	}loop();
	$("#loginMemeber").on('submit', function(e){
		e.preventDefault();
		var data = $(this).serialize();
		$.ajax({
			url: '../wp-content/themes/redefining-health/member/addmember.php',
			method: 'POST',
			data: data,
			success : function(data){
				$("#resultLogin").html(data);
			}
		});
	});

	$(".forModal").on('click', function(){
		$("#membershipModalID").modal('show');
	});	

	var width = $(window).width();
	if (width > 991) {
		var searchField = $(".search-field").val();
		if ( searchField != '') {
			$(".search-field").css("font-size", "16px");
			$(".search-field").css("line-height", "216%");
		}

		$(".search-field").keyup(function(){
			var val = $(this).val();
			$(this).css("font-size", "16px");
			$(this).css("line-height", "216%");
			if (val == '') {
				$(this).css("font-size", "12px");
				$(this).css("line-height", "288%");
			}
		});
	}else{
		$(".search-field").css("font-size", "16px");
		$(".search-field").css("line-height", "216%");
	}

	$(".dkpdf-button-icon i").attr("class", "fa fa-print printIcon");
	$(".woocommerce-account .page_content .woocommerce .woocommerce-form-login").append('<div class="regButton"><a href="http://redefininghealth.ripecustomdesign.com/registration-form/">Click Here to Register</a></div>')

	$(".images .slick-slider .zoom img").on('click', function(){
		var image = $(this).prev('img').attr('src');
		var imageObj = '<img src="'+image+'" class="modMainProductImg img-responsive">';
		$("#modalProduct").find(".imageProd").html(imageObj);
		$("#modalProduct").modal('show');
		$(".modThumbProductImg").each(function(index){
			var thisImage = $(this).attr('src');
			if (thisImage == image) {
				$(this).addClass('modThumbActive');
			}else{
				$(this).removeClass('modThumbActive');
			}
		});

		var nextProd = $(".modThumbActive").next().attr('src');
		var prevProd = $(".modThumbActive").prev().attr('src');

		if (nextProd == undefined) {
			$("#productRightArrow").addClass('disabled');
		}

		if (prevProd == undefined) {
			$("#productLeftArrow").addClass('disabled');
		}
	});	

	$(".modThumbProductImg").on('click', function(){
		var ImgSrc = $(this).attr('src');
		var ImgSrcActive = $('.modMainProductImg').attr('src');
		$(this).addClass('modThumbActive');
		if (ImgSrc != ImgSrcActive) {
			$('.modMainProductImg').hide();
			$('.modMainProductImg').attr('src', ImgSrc);
			$('.modMainProductImg').fadeIn('slow');
			$(".modThumbProductImg").each(function(){
				var eachSrc = $(this).attr('src');
				if (eachSrc != ImgSrc) {
					$(this).removeClass('modThumbActive');
				}
			});
		}

		var nextProd = $(".modThumbActive").next().attr('src');
		var prevProd = $(".modThumbActive").prev().attr('src');

		if (nextProd == undefined) {
			$("#productRightArrow").addClass('disabled');
		}else{
			$("#productRightArrow").removeClass('disabled');
		}

		if (prevProd == undefined) {
			$("#productLeftArrow").addClass('disabled');
		}else{
			$("#productLeftArrow").removeClass('disabled');
		}
	});

	$("#productRightArrow").on('click', function(){
		$("#productLeftArrow").removeClass('disabled');
		var mainProd = $(".modMainProductImg").attr('src');
		var nextProdSrc = $(".modThumbActive").next('.modThumbProductImg').attr('src');
		$(".modThumbActive").next('.modThumbProductImg').addClass('modThumbActive');
		$(".modThumbActive").prev('.modThumbProductImg').removeClass('modThumbActive');
		$('.modMainProductImg').hide();
		var nowProduct = $(".modMainProductImg").attr('src', nextProdSrc);
		$('.modMainProductImg').fadeIn('slow');
		var nextProdSrcAgain = $(".modThumbActive").next('.modThumbProductImg').attr('src');
		if (nextProdSrcAgain == undefined) {
			$(this).addClass('disabled');
		}
	});

	$("#productLeftArrow").on('click', function(){
		$("#productRightArrow").removeClass('disabled');
		var mainProd = $(".modMainProductImg").attr('src');
		var prevProdSrc = $(".modThumbActive").prev('.modThumbProductImg').attr('src');
		$(".modThumbActive").prev('.modThumbProductImg').addClass('modThumbActive');
		$(".modThumbActive").next('.modThumbProductImg').removeClass('modThumbActive');
		$('.modMainProductImg').hide();
		var nowProduct = $(".modMainProductImg").attr('src', prevProdSrc);
		$('.modMainProductImg').fadeIn('slow');
		var prevProdSrcAgain = $(".modThumbActive").prev('.modThumbProductImg').attr('src');
		if (prevProdSrcAgain == undefined) {
			$(this).addClass('disabled');
		}
	});

	if ($('.blogImgInner iframe').length) {
		$('.blogImgInner iframe').removeAttr("sandbox security data-secret");
		$('.blogImgInner iframe').removeClass("wp-embedded-content").addClass("sproutvideo-player");
		$('.blogImgInner iframe').attr('allowfullscreen','');
		var splitVideoAttr = $('.blogImgInner iframe').attr('src');
		var theSproutSrc = splitVideoAttr.split("#")[0];
		$('.blogImgInner iframe').attr('src', theSproutSrc);
	}
	// $('.vidProdContent iframe')
	
	$('.vidProdContent iframe').removeAttr("sandbox security data-secret");
	$('.vidProdContent iframe').removeClass("wp-embedded-content").addClass("sproutvideo-player");
	$('.vidProdContent iframe').attr('allowfullscreen','');
	$('.vidProdContent iframe').each(function(index){
		var videoAttr = $(this).attr('src');
		var realSrc = videoAttr.split("#")[0];
		$(this).attr('src', realSrc);
	});
	
	$(".closeVideoModal").on('click', function(){
		$('.vidProdContent iframe').each(function(index){
			var theSrc = $(this).attr('src');
			$(this).attr('src', '');
			$(this).attr('src', theSrc);
		});
	});


	if ($('.fluid-width-video-wrapper iframe').length) {
		$('.fluid-width-video-wrapper iframe').removeAttr("sandbox security data-secret");
		$('.fluid-width-video-wrapper iframe').removeClass("wp-embedded-content").addClass("sproutvideo-player");
		$('.fluid-width-video-wrapper iframe').attr('allowfullscreen','');
		var splitVideoAttrPost = $('.fluid-width-video-wrapper iframe').attr('src');
		var theSproutSrcPost = splitVideoAttrPost.split("#")[0];
		$('.fluid-width-video-wrapper iframe').attr('src', theSproutSrcPost);
	}
	
	$('.product_content .cart .qty').keyup(function(){
		var qty = $(this).val();
		if (qty > 1000) {
			$(this).val('1');
			$('.product_content .cart').after('<div class="qtyError"> Please Input Quantity Lesser than 1000!');
			setTimeout(function(){
			 $('.qtyError').remove();
			}, 2000);
		}
	});

	// $('.woocommerce-shipping-calculator input[name=calc_shipping]').on('click',function(){
	// 	$('.woocommerce-info:contains("Unfortunately")').css('background-color', 'red');
	// 	$('.woocommerce-info:contains("Unfortunately")').css('color', 'white');
	// 	console.log('EXIST!');
	// });
	var interval = setInterval(function(){
		var woo_info = $('.woocommerce-info:contains("Unfortunately")');
		woo_info.css({ 'background-color' : 'red','color' : '#fff', 'position' : 'relative', 'padding-left' : '76px'});		
		if( ! woo_info.hasClass('addIconWarning') ) {
			woo_info.addClass('addIconWarning');
		}

		var woo_updated = $('.woocommerce-info:contains("updated")');
		woo_updated.css({ 'background-color' : '#06c6cc','color' : '#fff', 'position' : 'relative', 'padding-left' : '76px'});		
		if( ! woo_updated.hasClass('addIconCheck') ) {
			woo_updated.addClass('addIconCheck');
		}

		var woo_updated = $('.woocommerce-message:contains("updated")');
		woo_updated.css({ 'background-color' : '#06c6cc','color' : '#fff', 'position' : 'relative', 'padding-left' : '76px', 'border-top' : '3px solid #144354'});		
		if( ! woo_updated.hasClass('addIconCheck') ) {
			woo_updated.addClass('addIconCheck');
		}
	}, 100);

});

