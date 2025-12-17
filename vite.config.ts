import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  assetsInclude: ['**/*.MP4', '**/*.mp4'],
  server: {
    proxy: {
      '/api': {
        target: 'https://coffeeplug-api-b982ba0e7659.herokuapp.com',
        changeOrigin: true,
        secure: false,
        cookieDomainRewrite: 'localhost',
      }
    }
  },
  build: {
    assetsInlineLimit: 0, // Don't inline assets, always emit them as separate files
    rollupOptions: {
      output: {
        assetFileNames: (assetInfo) => {
          // Keep SVG files as separate assets with proper naming
          if (assetInfo.name && assetInfo.name.endsWith('.svg')) {
            return 'assets/[name]-[hash][extname]'
          }
          return 'assets/[name]-[hash][extname]'
        }
      }
    }
  }
})






