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
    outputDir: 'dist',
    assetsDir: './static',
    publicPath:'./',
    devServer: {
        proxy: {
            '/api': {
                target: 'http://yisuixinFrame.com',
                changeOrigin: true,
                ws: true,
                pathRewrite: {
                    '^/api': ''
                }
            },
        }
    }
}