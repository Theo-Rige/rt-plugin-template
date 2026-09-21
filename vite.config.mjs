import { defineConfig } from 'vite';
import { resolve, extname, relative } from 'path';
import fg from 'fast-glob';

const globSync = fg.globSync;

export default defineConfig({
	appType: 'custom',
	server: {
		cors: true,
		strictPort: true,
		hmr: {
			host: 'localhost'
		}
	},
	build: {
		sourcemap: true,
		rollupOptions: {
			input: globSync(['assets/js/**/*.js', 'assets/scss/**/*.scss', '!assets/scss/**/_*.scss']).reduce((acc, file) => {
				let name = relative('assets', file.slice(0, -extname(file).length));

				name = name.replace(/\\/g, '/');
				name = name.replace(/^(js|scss)\//, '');

				acc[name] = resolve(import.meta.dirname, file);

				return acc;
			}, {}),
			output: {
				entryFileNames: 'js/[name].min.js',
				chunkFileNames: 'js/chunks/[name].min.js',
				assetFileNames: (assetInfo) => {
					if (assetInfo.names?.[0] && assetInfo.names?.[0].endsWith('.css')) {
						return 'css/[name].min.[ext]';
					}
					return 'assets/[name].[ext]';
				}
			}
		}
	}
});
