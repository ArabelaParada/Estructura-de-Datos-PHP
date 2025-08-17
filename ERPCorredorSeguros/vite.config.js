import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
  root: path.resolve(__dirname, 'src'),
  server: {
    port: 5173, // Puerto estándar
    strictPort: true,
    open: true // Abre navegador automáticamente
  },
  build: {
    outDir: path.resolve(__dirname, 'dist'),
    emptyOutDir: true
  }
});