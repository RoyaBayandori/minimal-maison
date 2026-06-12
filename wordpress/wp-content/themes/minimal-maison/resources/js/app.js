/**
 * Minimal Maison — front-end entry (Vite).
 */
import '../css/app.css';

/**
 * Craft Process — image preview panel (hover / click / keyboard).
 */
function initCraftProcessPreview() {
	const section = document.querySelector( '.mm-craft-process--preview' );

	if ( ! section ) {
		return;
	}

	const triggers = section.querySelectorAll( '.mm-craft-process__trigger' );
	const layers   = section.querySelectorAll( '.mm-craft-process__preview-layer' );
	const steps    = section.querySelectorAll( '.mm-craft-process__step[data-craft-index]' );
	const panel    = section.querySelector( '.mm-craft-process__preview-stage' );

	if ( ! triggers.length || ! layers.length ) {
		return;
	}

	const defaultIndex = Number.parseInt( section.dataset.defaultIndex ?? '0', 10 );
	let activeIndex    = Number.isNaN( defaultIndex ) ? 0 : defaultIndex;
	let lastImageIndex = activeIndex;

	const finePointer = window.matchMedia( '(hover: hover) and (pointer: fine)' );

	const findLayer = ( index ) =>
		Array.from( layers ).find(
			( layer ) => Number.parseInt( layer.dataset.craftIndex ?? '-1', 10 ) === index
		);

	const setActive = ( index ) => {
		const layer = findLayer( index );

		if ( layer ) {
			lastImageIndex = index;
		}

		activeIndex = index;
		const imageIndex = layer ? index : lastImageIndex;

		triggers.forEach( ( trigger ) => {
			const triggerIndex = Number.parseInt( trigger.dataset.craftIndex ?? '-1', 10 );
			const isSelected   = triggerIndex === index;

			trigger.setAttribute( 'aria-selected', isSelected ? 'true' : 'false' );
		} );

		steps.forEach( ( step ) => {
			const stepIndex = Number.parseInt( step.dataset.craftIndex ?? '-1', 10 );
			step.classList.toggle( 'is-active', stepIndex === index );
		} );

		layers.forEach( ( item ) => {
			const layerIndex = Number.parseInt( item.dataset.craftIndex ?? '-1', 10 );
			const isVisible  = layerIndex === imageIndex;

			item.classList.toggle( 'is-active', isVisible );
			item.toggleAttribute( 'data-active', isVisible );
		} );

		const labelledBy = section.querySelector( `#craft-step-tab-${ index }` );

		if ( panel && labelledBy ) {
			panel.setAttribute( 'aria-labelledby', labelledBy.id );
		}
	};

	triggers.forEach( ( trigger ) => {
		const index = Number.parseInt( trigger.dataset.craftIndex ?? '-1', 10 );

		if ( index < 0 ) {
			return;
		}

		trigger.addEventListener( 'click', () => {
			setActive( index );
		} );

		trigger.addEventListener( 'focus', () => {
			setActive( index );
		} );

		if ( finePointer.matches ) {
			trigger.addEventListener( 'mouseenter', () => {
				setActive( index );
			} );
		}
	} );

	setActive( activeIndex );
}

/**
 * Featured Creations — horizontal collection rail (mouse drag on fine pointers).
 */
function initFeaturedCreationsRail() {
	const rail = document.querySelector( '.mm-featured-creations__rail' );

	if ( ! rail ) {
		return;
	}

	const desktopRail = window.matchMedia( '(min-width: 1200px)' );
	const finePointer = window.matchMedia( '(hover: hover) and (pointer: fine)' );

	const syncScrollable = () => {
		if ( ! desktopRail.matches ) {
			rail.classList.remove( 'is-scrollable', 'is-dragging' );
			return;
		}

		rail.classList.toggle( 'is-scrollable', rail.scrollWidth > rail.clientWidth + 1 );
	};

	syncScrollable();
	window.addEventListener( 'resize', syncScrollable, { passive: true } );
	desktopRail.addEventListener( 'change', syncScrollable );
	rail.querySelectorAll( 'img' ).forEach( ( img ) => {
		if ( ! img.complete ) {
			img.addEventListener( 'load', syncScrollable, { once: true } );
		}
	} );

	if ( ! finePointer.matches ) {
		return;
	}

	let isDragging  = false;
	let startX      = 0;
	let scrollStart = 0;

	const endDrag = ( event ) => {
		if ( ! isDragging ) {
			return;
		}

		isDragging = false;
		rail.classList.remove( 'is-dragging' );

		if ( rail.hasPointerCapture( event.pointerId ) ) {
			rail.releasePointerCapture( event.pointerId );
		}
	};

	rail.addEventListener( 'pointerdown', ( event ) => {
		if (
			event.button !== 0
			|| ! desktopRail.matches
			|| ! rail.classList.contains( 'is-scrollable' )
		) {
			return;
		}

		isDragging  = true;
		startX      = event.clientX;
		scrollStart = rail.scrollLeft;
		rail.classList.add( 'is-dragging' );
		rail.setPointerCapture( event.pointerId );
	} );

	rail.addEventListener( 'pointermove', ( event ) => {
		if ( ! isDragging ) {
			return;
		}

		event.preventDefault();
		rail.scrollLeft = scrollStart - ( event.clientX - startX );
	} );

	rail.addEventListener( 'pointerup', endDrag );
	rail.addEventListener( 'pointercancel', endDrag );
}

/**
 * Mobile header — hamburger menu toggle.
 */
function initMobileNav() {
	const toggle = document.querySelector( '.site-header__menu-toggle' );
	const panel  = document.getElementById( 'site-mobile-nav' );

	if ( ! toggle || ! panel ) {
		return;
	}

	const setOpen = ( isOpen ) => {
		toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		toggle.setAttribute(
			'aria-label',
			isOpen ? 'بستن منو' : 'باز کردن منو'
		);
		panel.hidden = ! isOpen;
		panel.classList.toggle( 'is-open', isOpen );
	};

	toggle.addEventListener( 'click', () => {
		const isOpen = toggle.getAttribute( 'aria-expanded' ) === 'true';
		setOpen( ! isOpen );
	} );

	document.addEventListener( 'keydown', ( event ) => {
		if ( event.key === 'Escape' && toggle.getAttribute( 'aria-expanded' ) === 'true' ) {
			setOpen( false );
			toggle.focus();
		}
	} );
}

/**
 * FAQ accordion — Custom Order landing page only.
 */
function initCustomOrderFaq() {
	const faqSection = document.querySelector( '.mm-custom-order-faq' );

	if ( ! faqSection ) {
		return;
	}

	const closeFaqItem = ( item ) => {
		if ( ! item ) {
			return;
		}

		const trigger = item.querySelector( '.mm-custom-order-faq__trigger' );
		const panel = item.querySelector( '.mm-custom-order-faq__panel' );

		item.classList.remove( 'is-open' );

		if ( trigger ) {
			trigger.setAttribute( 'aria-expanded', 'false' );
		}

		if ( panel ) {
			panel.style.maxHeight = '0';
			panel.setAttribute( 'aria-hidden', 'true' );
		}
	};

	const openFaqItem = ( item ) => {
		const trigger = item.querySelector( '.mm-custom-order-faq__trigger' );
		const panel = item.querySelector( '.mm-custom-order-faq__panel' );

		item.classList.add( 'is-open' );

		if ( trigger ) {
			trigger.setAttribute( 'aria-expanded', 'true' );
		}

		if ( panel ) {
			panel.style.maxHeight = `${ panel.scrollHeight }px`;
			panel.setAttribute( 'aria-hidden', 'false' );
		}
	};

	faqSection.querySelectorAll( '.mm-custom-order-faq__trigger' ).forEach( ( trigger ) => {
		trigger.addEventListener( 'click', () => {
			const item = trigger.closest( '.mm-custom-order-faq__item' );
			const panel = item?.querySelector( '.mm-custom-order-faq__panel' );

			if ( ! item || ! panel ) {
				return;
			}

			const isOpen = item.classList.contains( 'is-open' );

			faqSection.querySelectorAll( '.mm-custom-order-faq__item.is-open' ).forEach( ( openItem ) => {
				if ( openItem !== item ) {
					closeFaqItem( openItem );
				}
			} );

			if ( isOpen ) {
				closeFaqItem( item );
				return;
			}

			openFaqItem( item );
		} );
	} );
}

/**
 * Portfolio gallery — category filters and luxury lightbox.
 */
function initPortfolioGallery() {
	const section = document.querySelector( '[data-portfolio-gallery]' );
	const config = window.mmPortfolioGallery ?? null;

	if ( ! section || ! config?.ajaxUrl ) {
		return;
	}

	const grid = section.querySelector( '[data-portfolio-grid]' );
	const actions = section.querySelector( '[data-portfolio-actions]' );
	const loadMoreButton = section.querySelector( '[data-portfolio-load-more]' );
	const emptyState = section.querySelector( '[data-portfolio-empty]' );
	const filterButtons = section.querySelectorAll( '[data-portfolio-filter]' );
	const lightbox = section.querySelector( '[data-portfolio-lightbox]' );
	const lightboxImage = lightbox?.querySelector( '[data-portfolio-lightbox-image]' );
	const lightboxTitle = lightbox?.querySelector( '[data-portfolio-lightbox-title]' );
	const lightboxCategory = lightbox?.querySelector( '[data-portfolio-lightbox-category]' );
	const lightboxMeta = lightbox?.querySelector( '[data-portfolio-lightbox-meta]' );
	const lightboxMetaWrap = lightbox?.querySelector( '[data-portfolio-lightbox-meta-wrap]' );
	const lightboxStory = lightbox?.querySelector( '[data-portfolio-lightbox-story]' );
	const lightboxStoryWrap = lightbox?.querySelector( '[data-portfolio-lightbox-story-wrap]' );
	const lightboxYear = lightbox?.querySelector( '[data-portfolio-lightbox-year]' );
	const lightboxYearWrap = lightbox?.querySelector( '[data-portfolio-lightbox-year-wrap]' );
	const manifestNode = section.querySelector( '[data-portfolio-manifest]' );

	if ( ! grid || ! manifestNode ) {
		return;
	}

	let manifest = [];
	let activeFilter = 'all';
	let activeIndex = 0;
	let loadedOffset = parseInt( section.dataset.portfolioOffset ?? '0', 10 );
	let totalCount = parseInt( section.dataset.portfolioTotal ?? '0', 10 );
	let isLoading = false;

	try {
		manifest = JSON.parse( manifestNode.textContent ?? '[]' );
	} catch {
		manifest = [];
	}

	const filteredManifest = () => {
		if ( 'all' === activeFilter ) {
			return manifest;
		}

		return manifest.filter( ( entry ) =>
			Array.isArray( entry.cats ) ? entry.cats.includes( activeFilter ) : false
		);
	};

	const setLightboxField = ( node, wrap, value ) => {
		if ( ! node ) {
			return;
		}

		const text = ( value ?? '' ).trim();

		node.textContent = text;

		if ( wrap ) {
			wrap.hidden = '' === text;
		} else {
			node.hidden = '' === text;
		}
	};

	const populateLightboxEntry = ( entry, animate = false ) => {
		if ( ! lightboxImage || ! entry ) {
			return;
		}

		const applyContent = () => {
			lightboxImage.src = entry.full ?? '';
			lightboxImage.alt = entry.title ?? '';

			setLightboxField( lightboxTitle, null, entry.title ?? '' );
			setLightboxField( lightboxCategory, null, entry.category ?? '' );
			setLightboxField( lightboxMeta, lightboxMetaWrap, entry.subtitle ?? '' );
			setLightboxField( lightboxStory, lightboxStoryWrap, entry.story ?? '' );
			setLightboxField(
				lightboxYear,
				lightboxYearWrap,
				entry.year ? String( entry.year ) : ''
			);

			lightboxImage.classList.remove( 'is-changing' );
		};

		if ( animate && lightboxImage.getAttribute( 'src' ) ) {
			lightboxImage.classList.add( 'is-changing' );
			window.setTimeout( applyContent, 240 );
			return;
		}

		applyContent();
	};

	const openLightboxById = ( itemId, animate = false ) => {
		if ( ! lightbox || ! lightboxImage ) {
			return;
		}

		const items = filteredManifest();
		const index = items.findIndex( ( entry ) => String( entry.id ) === String( itemId ) );

		if ( index < 0 ) {
			return;
		}

		activeIndex = index;
		populateLightboxEntry( items[ index ], animate );

		lightbox.hidden = false;
		lightbox.classList.add( 'is-open' );
		lightbox.setAttribute( 'aria-hidden', 'false' );
		document.body.classList.add( 'mm-portfolio-lightbox-open' );
	};

	const closeLightbox = () => {
		if ( ! lightbox || ! lightboxImage ) {
			return;
		}

		lightbox.hidden = true;
		lightbox.classList.remove( 'is-open' );
		lightbox.setAttribute( 'aria-hidden', 'true' );
		lightboxImage.removeAttribute( 'src' );
		lightboxImage.classList.remove( 'is-changing' );
		setLightboxField( lightboxTitle, null, '' );
		setLightboxField( lightboxCategory, null, '' );
		setLightboxField( lightboxMeta, lightboxMetaWrap, '' );
		setLightboxField( lightboxStory, lightboxStoryWrap, '' );
		setLightboxField( lightboxYear, lightboxYearWrap, '' );
		document.body.classList.remove( 'mm-portfolio-lightbox-open' );
	};

	const stepLightbox = ( direction ) => {
		const items = filteredManifest();

		if ( ! items.length ) {
			return;
		}

		activeIndex = ( activeIndex + direction + items.length ) % items.length;
		populateLightboxEntry( items[ activeIndex ], true );
	};

	const updateLoadMore = ( hasMore ) => {
		if ( ! actions || ! loadMoreButton ) {
			return;
		}

		actions.hidden = ! hasMore;
		loadMoreButton.disabled = false;
		loadMoreButton.classList.remove( 'is-loading' );
	};

	const fetchBatch = async ( offset, category, replace = false ) => {
		if ( isLoading ) {
			return null;
		}

		isLoading = true;

		if ( loadMoreButton ) {
			loadMoreButton.disabled = true;
			loadMoreButton.classList.add( 'is-loading' );
		}

		const body = new URLSearchParams( {
			action: 'mm_portfolio_gallery_batch',
			nonce: config.nonce,
			offset: String( offset ),
			category,
		} );

		try {
			const response = await fetch( config.ajaxUrl, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
				},
				body: body.toString(),
				credentials: 'same-origin',
			} );

			const payload = await response.json();

			if ( ! payload?.success || ! payload.data ) {
				return null;
			}

			if ( replace ) {
				grid.innerHTML = payload.data.html ?? '';
			} else {
				grid.insertAdjacentHTML( 'beforeend', payload.data.html ?? '' );
			}

			loadedOffset = parseInt( payload.data.offset ?? '0', 10 );
			totalCount = parseInt( payload.data.total ?? '0', 10 );
			section.dataset.portfolioOffset = String( loadedOffset );
			section.dataset.portfolioTotal = String( totalCount );

			updateLoadMore( Boolean( payload.data.has_more ) );

			if ( emptyState ) {
				emptyState.hidden = totalCount > 0;
			}

			return payload.data;
		} catch {
			updateLoadMore( loadedOffset < totalCount );
			return null;
		} finally {
			isLoading = false;
		}
	};

	const applyFilter = async ( filter ) => {
		activeFilter = filter;

		filterButtons.forEach( ( button ) => {
			const isActive = button.dataset.portfolioFilter === filter;

			button.classList.toggle( 'is-active', isActive );
			button.setAttribute( 'aria-pressed', isActive ? 'true' : 'false' );
		} );

		await fetchBatch( 0, filter, true );
	};

	filterButtons.forEach( ( button ) => {
		button.addEventListener( 'click', () => {
			const filter = button.dataset.portfolioFilter ?? 'all';

			if ( filter === activeFilter || isLoading ) {
				return;
			}

			applyFilter( filter );
		} );
	} );

	loadMoreButton?.addEventListener( 'click', () => {
		if ( isLoading || loadedOffset >= totalCount ) {
			return;
		}

		fetchBatch( loadedOffset, activeFilter, false );
	} );

	grid.addEventListener( 'click', ( event ) => {
		const trigger = event.target.closest( '[data-portfolio-open]' );

		if ( ! trigger || ! grid.contains( trigger ) ) {
			return;
		}

		const piece = trigger.closest( '[data-portfolio-piece]' );

		if ( ! piece ) {
			return;
		}

		openLightboxById( piece.dataset.portfolioId ?? '' );
	} );

	lightbox?.querySelectorAll( '[data-portfolio-lightbox-close]' ).forEach( ( node ) => {
		node.addEventListener( 'click', closeLightbox );
	} );

	lightbox?.querySelector( '[data-portfolio-lightbox-prev]' )?.addEventListener( 'click', () => {
		stepLightbox( -1 );
	} );

	lightbox?.querySelector( '[data-portfolio-lightbox-next]' )?.addEventListener( 'click', () => {
		stepLightbox( 1 );
	} );

	document.addEventListener( 'keydown', ( event ) => {
		if ( ! lightbox || lightbox.hidden ) {
			return;
		}

		if ( 'Escape' === event.key ) {
			closeLightbox();
			return;
		}

		if ( 'ArrowLeft' === event.key ) {
			stepLightbox( 1 );
			return;
		}

		if ( 'ArrowRight' === event.key ) {
			stepLightbox( -1 );
		}
	} );
}

document.addEventListener( 'DOMContentLoaded', () => {
	document.documentElement.classList.add( 'mm-js' );

	initCraftProcessPreview();
	initFeaturedCreationsRail();
	initMobileNav();
	initCustomOrderFaq();
	initPortfolioGallery();

	const fileInput = document.getElementById( 'mm_request_reference' );

	if ( ! fileInput ) {
		return;
	}

	const fileName = fileInput
		.closest( '.mm-form-file-wrap' )
		?.querySelector( '.mm-form-file-name' );

	if ( ! fileName ) {
		return;
	}

	const emptyLabel = fileName.dataset.empty || fileName.textContent;

	fileInput.addEventListener( 'change', () => {
		const files = fileInput.files;

		if ( ! files || files.length === 0 ) {
			fileName.textContent = emptyLabel;
			return;
		}

		if ( files.length === 1 ) {
			fileName.textContent = files[ 0 ].name;
			return;
		}

		fileName.textContent = `${ files.length } فایل انتخاب شد`;
	} );
} );
