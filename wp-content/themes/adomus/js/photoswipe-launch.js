jQuery( document ).ready( function( $ ) {
	
	"use strict";
	
	var photoswipe_mark_up = '' +
		'<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">' +
			'<div class="pswp__bg"></div>' +
			'<div class="pswp__scroll-wrap">' +
				'<div class="pswp__container">' +
					'<div class="pswp__item"></div>' +
					'<div class="pswp__item"></div>' +
					'<div class="pswp__item"></div>' +
				'</div>' +
				'<div class="pswp__ui pswp__ui--hidden">' +
					'<div class="pswp__top-bar">' +
						'<div class="pswp__counter"></div>' +
						'<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>' +
						'<button class="pswp__button pswp__button--share" title="Share"></button>' +
						'<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>' +
						'<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>' +
						'<div class="pswp__preloader">' +
							'<div class="pswp__preloader__icn">' +
								'<div class="pswp__preloader__cut">' +
									'<div class="pswp__preloader__donut"></div>' +
								'</div>' +
							'</div>' +
						'</div>' +
					'</div>' +
					'<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">' +
						'<div class="pswp__share-tooltip"></div> ' +
					'</div>' +
					'<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>' +
					'<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>' +
					'<div class="pswp__caption">' +
						'<div class="pswp__caption__center"></div>' +
					'</div>' +
				'</div>' +
			'</div>' +
		'</div>';
	
	$( 'body' ).append( photoswipe_mark_up );
	var pswpElement = $( '.pswp' )[0];

	var options = {
		bgOpacity: 0.9,
		showHideOpacity: true,
		loop: false,
		shareEl: false
	};

	$( 'body' ).on( 'click', '.photoswipe-item', function( e ) {
        e.preventDefault();
		var $clicked_thumbnail = $( this ),
            items = [],
            $items = $clicked_thumbnail.parents( '.gallery-wrapper' ).find( '.photoswipe-item' );
        if ( $items.length < 1 ) {
            $items = $clicked_thumbnail;
            options.index = 0;
        } else {
            options.index = $items.index( $clicked_thumbnail );
        }
         
		$items.each( function() {
			var item = {
				src: $( this ).attr( 'href' ),
				w: $( this ).data( 'width' ),
				h: $( this ).data( 'height' ),
				title: $( this ).data( 'caption' )
			};
			items.push( item );
		});
        var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options );
		$( 'body' ).css( 'overflow', 'hidden' );
		gallery.init();
		if ( $( '#wpadminbar' ).length > 0 ) {
			$( '.pswp' ).css( 'top', '32px' );
			$( '.pswp__caption' ).css( 'bottom', '32px' );
		}
		gallery.listen( 'close', function() { 
			$( 'body' ).css( 'overflow', 'auto' );
		});
	});
	
});