module.exports = {
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
            '/v1': {
                target: 'http://YsuixinCMS.com',
                changeOrigin: true,
                ws: true,
                pathRewrite: {
                    '^/v1': ''
                }
            },
        }
    }
}