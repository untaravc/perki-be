module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        extend: {
            fontFamily: {
                'sans': ['Arial'],
                'serif': ['Arial'],
            },
        },
        fontFamily: {
            sans: ['Arial', 'sans-serif'],
            serif: ['Arial', 'serif'],
        },
    },
    plugins: [
        require('flowbite/plugin')
    ],
}
