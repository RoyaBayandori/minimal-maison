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

document.addEventListener( 'DOMContentLoaded', () => {
	document.documentElement.classList.add( 'mm-js' );

	initCraftProcessPreview();
	initFeaturedCreationsRail();
	initMobileNav();
	initCustomOrderFaq();

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
