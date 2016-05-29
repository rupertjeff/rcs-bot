var webpack = require('webpack'),
    path = require('path'),
    jsPath = path.join(__dirname, 'resources', 'assets', 'js'),
    publicJsPath = path.join(__dirname, 'public', 'js');

module.exports = {
    target: 'web',
    entry: {
        app: path.join(jsPath, 'app'),
        common: [
            'react',
            'react-dom',
            'react-dnd',
            'react-dnd-html5-backend',
            'axios'
        ]
    },
    output: {
        path: publicJsPath,
        publicPath: '',
        filename: '[name].js',
        library: ['RCSDiscordBot', '[name]'],
        pathInfo: true
    },
    resolve: {
        root: path.join(__dirname),
        extensions: ['', '.js', '.jsx']
    },
    module: {
        loaders: [
            {
                test: /\.jsx?$/,
                exclude: /node_modules/,
                loader: 'babel'
            }
        ]
    },
    plugins: [
        new webpack.optimize.CommonsChunkPlugin('common', 'common.js'),
        new webpack.NoErrorsPlugin()
    ],
    debug: true
};
