const colors = require('tailwindcss/colors');
const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    '../core/views/_base/template_install.php',
    '../core/views/_base/template_update.php',
    '../core/views/_base/install/pages/*',
    '../core/views/_base/update/pages/*',
    '../core/controllers/nova_install.php',
    '../core/controllers/nova_update.php',
    '../core/helpers/*',
    '../core/language/english/*'
  ],
  theme: {
    extend: {
      colors: {
        gray: colors.zinc,
        danger: colors.rose,
        warning: colors.amber,
        success: colors.emerald,
        info: colors.purple
      },
      fontFamily: {
        'sans': ['Geist', ...defaultTheme.fontFamily.sans]
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography')
  ],
}
