const path = require('path');
const CopyPlugin = require('copy-webpack-plugin');

module.exports = {
    mode: 'production',

    entry: {},

    output: {
        path: path.resolve(__dirname, 'assets'),
        clean: true,
    },

    plugins: [
        new CopyPlugin({
            patterns: [

                // Font Awesome CSS
                {
                    from: 'node_modules/@fortawesome/fontawesome-free/css/fontawesome.min.css',
                    to: 'css/fontawesome.min.css'
                },

                // Font Awesome webfonts
                {
                    from: 'node_modules/@fortawesome/fontawesome-free/webfonts',
                    to: 'webfonts'
                },

                // Your JS files
                {
                    from: 'src/*.js',
                    to: 'js/[name][ext]'
                }

            ]
        })
    ]
};
