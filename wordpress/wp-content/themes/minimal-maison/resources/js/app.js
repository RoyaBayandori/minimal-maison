/**
 * Minimal Maison — front-end entry (Vite).
 */
import '../css/app.css';

document.addEventListener( 'DOMContentLoaded', () => {
	document.documentElement.classList.add( 'mm-js' );

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
