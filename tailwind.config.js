/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#e6f7f7',
                    100: '#ccefef',
                    200: '#99dfdf',
                    300: '#66cfcf',
                    400: '#33bfbf',
                    500: '#00afaf',
                    600: '#008c8c',
                    700: '#006969',
                    800: '#004646',
                    900: '#002323',
                },
                accent: {
                    50: '#fff4e6',
                    100: '#ffe8cc',
                    200: '#ffd199',
                    300: '#ffba66',
                    400: '#ffa333',
                    500: '#ff8c00',
                    600: '#cc7000',
                    700: '#995400',
                    800: '#663800',
                    900: '#331c00',
                },
                dark: {
                    50: '#f5f5f5',
                    100: '#e0e0e0',
                    200: '#bdbdbd',
                    300: '#9e9e9e',
                    400: '#757575',
                    500: '#616161',
                    600: '#424242',
                    700: '#303030',
                    800: '#1a1a1a',
                    900: '#0d0d0d',
                    950: '#050505',
                },
            },
            fontFamily: {
                'heading': ['Poppins', 'sans-serif'],
                'body': ['Inter', 'sans-serif'],
            },
        },
    },
    plugins: [],
}
