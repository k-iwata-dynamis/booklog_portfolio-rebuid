/* tailwind.config.js */
//const path = require('path');
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        'smarthr-blue': '#00c4cc',
        'smarthr-black': '#23221f',
        'smarthr-orange': '#ff9900',
        'smarthr-white': '#ffffff',
      },
      fontFamily: {
        'yu-gothic': ['"游ゴシック体"', 'Yu Gothic', 'sans-serif'],
        'noto-sans-jp': ['"Noto Sans JP"', 'sans-serif'],
      },
    },
  },
  plugins: [],
};
