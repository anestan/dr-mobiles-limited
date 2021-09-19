module.exports = {
  corePlugins: {
    preflight: false,
  },
  important: true,
  mode: 'jit',
  purge: {
    enabled: true,
    content: [
      './views/**/*.php',
      './assets/**/*.{scss,js,vue}',
    ]
  },
  darkMode: false,
  theme: {
    screens: {
      'sm': '640px',
      'md': '768px',
      'lg': '1024px',
      'xl': '1280px',
      '2xl': '1366px',
    },
    extend: {
      fontFamily: {
        'primary': ['Poppins', 'sans-serif',],
        'secondary': ['Sarpanch', 'sans-serif',],
      },
      colors: {
        'dml-blue': {
          DEFAULT: '#0404C6',
          '50': '#B2B2FD',
          '100': '#9999FD',
          '200': '#6767FC',
          '300': '#3535FB',
          '400': '#0505F8',
          '500': '#0404C6',
          '600': '#030394',
          '700': '#020262',
          '800': '#010130',
          '900': '#000000'
        },
        'covid-yellow': {
          DEFAULT: '#FFCC00',
          '50': '#FFFAE5',
          '100': '#FFF5CC',
          '200': '#FFEB99',
          '300': '#FFE066',
          '400': '#FFD633',
          '500': '#FFCC00',
          '600': '#CCA300',
          '700': '#997A00',
          '800': '#665200',
          '900': '#332900'
        },
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('tailwindcss-debug-screens'),
    // require('@tailwindcss/line-clamp'),
    // require('@tailwindcss/forms'),
  ],
};
