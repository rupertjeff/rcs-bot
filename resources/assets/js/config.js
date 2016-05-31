export default {
    apiUrl: [
        window.baseUrl,
        'api'
    ].map(function (value) {
        return value
            .replace(/^\/+/, '')
            .replace(/\/+$/, '');
    }).join('/')
};

String.prototype.ucwords = function () {
    var me = this.trim();
    var pieces = me.split(/\s+/gi);

    pieces.forEach(function (value) {
        return value.toUpperCase();
    });

    return pieces.join(' ');
};
