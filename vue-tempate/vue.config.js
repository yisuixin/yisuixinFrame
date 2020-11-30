const webpack = require('webpack')
module.exports = {
    configureWebpack: {
        plugins: [
            new webpack.ProvidePlugin({
                $:"jquery",
                jQuery:"jquery",
                "windows.jQuery":"jquery"
            })
        ]
    },
    lintOnSave: false,
    outputDir: 'vueTest',
    assetsDir:'static',
    publicPath:'',
    // devServer: {
    //     disableHostCheck: false,
    //     host: "vueTest.com",
    //     port: 80,
    //     https: false,
    //     hotOnly: false,
    //     proxy: null
    // },
    devServer: {
        proxy: {
            '/mork': {
                target: 'http://yisuixinFrame.com',
                changeOrigin: true,
                ws: true,
                pathRewrite: {
                    '^/mork': ''
                }
            },
        }
    }
}