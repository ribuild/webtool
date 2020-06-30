module.exports = {
    theme: {
        extend: {
            fontSize: {
                'xxs': '.6rem',
            },
            spacing: {
                '72': '18rem',
                '80': '20rem',
                '100': '25rem'
            },
            colors: {
                ribuild: '#5a2a1c',
                // indigo: {
                //     '100': '#ffefea',
                //     '200': '#f7cbbd',
                //     '300': '#ddb1a3',
                //     '400': '#bd9183',
                //     '500': '#a37769',
                //     '600': '#906456',
                //     '700': '#7c5042',
                //     '800': '#6a3e30',
                //     '900': '#5e3224',
                // }
            },
            maxHeight: {
                '64': '16rem',
                '128': '32rem'
            }
        }
    },
    variants: {},
    plugins: [
        require('@tailwindcss/ui'),
    ]
}
