import { defineConfig } from 'vite';
import path from 'path';
import { fileURLToPath } from 'url';

const themeRoot = path.dirname( fileURLToPath( import.meta.url ) );

export default defineConfig( {
	root: themeRoot,
	// Dev: WordPress enqueues http://localhost:5173/resources/js/app.js (no theme path prefix).
	// Prod: manifest paths are resolved via get_template_directory_uri() in inc/assets.php.
	// Relative base keeps bundled font URLs beside dist/assets/*.css in WordPress.
	base: process.env.NODE_ENV === 'production' ? './' : '/',
	server: {
		host: '0.0.0.0',
		port: 5173,
		strictPort: true,
		cors: true,
		origin: 'http://localhost:5173',
	},
	build: {
		manifest: true,
		outDir: path.resolve( themeRoot, 'dist' ),
		emptyOutDir: true,
		rollupOptions: {
			input: path.resolve( themeRoot, 'resources/js/app.js' ),
		},
	},
} );
