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

document.addEventListener( 'DOMContentLoaded', () => {
	document.documentElement.classList.add( 'mm-js' );

	initCraftProcessPreview();

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
		const selected = fileInput.files?.[ 0 ];

		fileName.textContent = selected ? selected.name : emptyLabel;
	} );
} );
