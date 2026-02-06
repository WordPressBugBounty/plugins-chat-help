; (function ($) {
	const hash = window.location.hash.replace('#', '').split('#')[1];
	$(window).on('hashchange', function() {
		let hash = window.location.hash.replace('#', '').split('#')[1];
		if ('get-start' === hash || 'recommended' === hash || 'lite-to-pro' === hash || 'pro-plugins' === hash || '#tab=help' === window.location.hash) {
			$('.chat-help-nav.chat-help-nav-options ul li:last-child a').addClass('chat-help-active');
			$('.chat-help-section[data-section-id="help"]').show();
		}
		if( !hash && '#tab=help' !== window.location.hash ) {
			$('.chat-help-section[data-section-id="help"]').hide();
		}
	})
	// Help page tab menu script.
	$('.chat-help').on('click', '.header_nav a', function (e) {
		if ($(this).hasClass('active')) {
			return;
		}
		let tabId = $(this).attr('data-id');
		$('.header_nav a').each((i, item) => {
			$(item).removeClass('active');
			$('#' + $(item).attr('data-id')).css('display', 'none');
		})
		$(this).addClass('active');

		$('#' + tabId).css('display', 'block');
	})

	if ('get-start' === hash || 'recommended' === hash || 'lite-to-pro' === hash || 'pro-plugins' === hash) {
		$('.chat-help-nav.chat-help-nav-options ul li:last-child a').addClass('chat-help-active');
		$('.chat-help-section[data-section-id="help"]').show();
	}

	if ('get-start' === hash) {
		$('.chat-help .header_nav a[data-id="get-start-tab"]').trigger('click');
	}

    if ('recommended' === hash) {
		$('.chat-help .header_nav a[data-id="recommended-tab"]').trigger('click');
	}
	if ('lite-to-pro' === hash) {
		$('.chat-help .header_nav a[data-id="lite-to-pro-tab"]').trigger('click');
	}
	if ('pro-plugins' === hash) {
		$('.chat-help .header_nav a[data-id="pro-plugins-tab"]').trigger('click');
	}

	$('body').on('click', '.install-now', function (e) {
		var _this = $(this);
		var _href = _this.attr('href');

		_this.addClass('updating-message').html('Installing...');

		$.get(_href, function (data) {
			location.reload();
		});

		e.preventDefault();
	});


	document.addEventListener("DOMContentLoaded", function () {
        const playListItems = document.querySelectorAll(".play_list_item");
        const iframe = document.querySelector(".video iframe");

        playListItems.forEach(item => {
            item.addEventListener("click", function () {
                // Get the video ID from data attribute
                const videoId = this.getAttribute("data-video_id");

                // Update iframe source
                iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;

                // Remove 'active' class from all items
                playListItems.forEach(el => el.classList.remove("active"));

                // Add 'active' class to clicked item
                this.classList.add("active");
            });
        });
    });

})(jQuery);