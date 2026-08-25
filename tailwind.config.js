/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: ['selector', '[data-theme="dark"]'],
  content: [
    './Views/**/*.{phtml,html,pinc}',
    './Views/**/.*.pinc',
    './Articles/**/*.phtml',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
