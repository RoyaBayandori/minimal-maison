/** @type {import('tailwindcss').Config} */
export default {
	content: [
		'./*.php',
		'./inc/**/*.php',
		'./template-parts/**/*.php',
		'./resources/**/*.{js,css}',
	],
	theme: {
		extend: {
			fontFamily: {
				sans: [ 'Vazirmatn', 'system-ui', 'sans-serif' ],
			},
			colors: {
				ivory: {
					50: '#fffdfa',
					100: '#fbf7f1',
					200: '#f4ede3',
				},
				ink: {
					900: '#161312',
					800: '#252120',
					700: '#3a3533',
				},
				gold: {
					300: '#d8c59a',
					400: '#c7ae78',
					500: '#b59559',
				},
				neutral: {
					50: '#fafaf9',
					100: '#f5f5f4',
					200: '#e7e5e4',
					300: '#d6d3d1',
					400: '#a8a29e',
					500: '#78716c',
					600: '#57534e',
					700: '#44403c',
					800: '#292524',
					900: '#1c1917',
				},
			},
			spacing: {
				26: '6.5rem',
				30: '7.5rem',
				34: '8.5rem',
				18: '4.5rem',
				22: '5.5rem',
			},
			fontSize: {
				'display-sm': [ '2.25rem', { lineHeight: '1.15', letterSpacing: '-0.01em' } ],
				'display-md': [ '3rem', { lineHeight: '1.1', letterSpacing: '-0.015em' } ],
				'display-lg': [ '4rem', { lineHeight: '1.05', letterSpacing: '-0.02em' } ],
			},
			letterSpacing: {
				editorial: '0.12em',
				luxury: '0.2em',
			},
			maxWidth: {
				'copy': '42rem',
				'content': '76rem',
				'8xl': '88rem',
			},
			boxShadow: {
				'mm-soft': '0 10px 35px rgba(22, 19, 18, 0.08)',
				'mm-card': '0 4px 18px rgba(22, 19, 18, 0.06)',
			},
		},
	},
	plugins: [],
};
