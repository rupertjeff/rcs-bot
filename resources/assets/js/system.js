/**
 * Name: system.js
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-31
 * Last Modified: 2016-03-31
 */
;(function (System) {
    System.config({
        packages: {
            js: {
                format: 'register',
                defaultExtension: 'js'
            }
        }
    });
    System.import('tsapp')
        .then(null, console.error.bind(console));
}(window.System));
