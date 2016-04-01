var elixir = require('laravel-elixir');

require('elixir-typescript');

elixir(function (mix) {
    mix.sass('app.scss')
        .scripts([
            './node_modules/es6-shim/es6-shim.min.js',
            './node_modules/angular2/es6/dev/src/testing/shims_for_IE.js',

            './node_modules/angular2/bundles/angular2-polyfills.js',
            './node_modules/rxjs/bundles/Rx.umd.js',
            './node_modules/angular2/bundles/angular2-all.umd.js'
        ], 'public/js/libraries.js')
        .scripts([
            'app.js'
        ], 'public/js/app.js')
        .copy('./node_modules/font-awesome/fonts', 'public/fonts')
        .version([
            'css/app.css',
            'js/libraries.js',
            'js/app.js'
        ]);

    // Setup for Typescript if that ever works...
    // mix.sass('app.scss')
    //     .scripts([
    //         './node_modules/es6-shim/es6-shim.min.js',
    //         './node_modules/systemjs/dist/system-polyfills.js',
    //         './node_modules/angular2/es6/dev/src/testing/shims_for_IE.js',
    //    
    //         './node_modules/angular2/bundles/angular2-polyfills.js',
    //         './node_modules/systemjs/dist/system.src.js',
    //         './node_modules/rxjs/bundles/Rx.js',
    //         './node_modules/angular2/bundles/angular2.dev.js',
    //         './node_modules/angular2/bundles/http.dev.js'
    //     ], 'public/js/tslibraries.js')
    //     .scripts([
    //         'system.js'
    //     ], 'public/js/system.js')
    //     .typescript('app.ts', 'public/js/tsapp.js')
    //     .copy('./node_modules/font-awesome/fonts', 'public/fonts')
    //     .version([
    //         'css/app.css',
    //         'js/tslibraries.js',
    //         'js/system.js'
    //     ]);
});
