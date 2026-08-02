const path = require("path");

module.exports = {
    mode: "production",

    entry: "./src/fobv-site-customisations.js",

    output: {
        path: path.resolve(__dirname, "assets"),
        filename: "fobv-site-customisations.js",
        clean: true,
    },

    externals: {
        jquery: "jQuery"
    },

    resolve: {
        extensions: [".js"],
    },
};
