/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./*.php",
        "./resources/**/*.{html,js,ts,php,vue}",
        "./src/**/*.php"
    ],
    theme: {
        extend: {
            colors: {
                'hexacore': {
                    'red': '#dc2626',
                    'red-dark': '#b91c1c',
                    'gray-950': '#0a0a0a',
                    'gray-900': '#111827',
                    'gray-800': '#1f2937',
                    'gray-700': '#374151'
                }
            },
            fontFamily: {
                'sans': ['Inter', 'system-ui', 'sans-serif'],
                'display': ['Roboto Slab', 'serif']
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-up': 'slideUp 0.6s ease-out',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'bounce-slow': 'bounce 2s infinite'
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' }
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(30px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' }
                }
            },
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
            },
            screens: {
                'xs': '475px'
            },
            zIndex: {
                '60': '60',
                '70': '70',
                '80': '80',
                '90': '90',
                '100': '100'
            }
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio')
    ]
};