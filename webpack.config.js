const defaults = require("@wordpress/scripts/config/webpack.config");

/**
 * WP-Scripts Webpack config.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-scripts/#provide-your-own-webpack-config
 */
module.exports = {
    ...defaults,
    entry: {
        admin: "./src/admin/index.js",
        frontend: "./src/frontend/index.js",
        customizer: "./src/customizer/index.js",
        "modal-cleanup": "./src/modal-cleanup/index.js",
    },
};
