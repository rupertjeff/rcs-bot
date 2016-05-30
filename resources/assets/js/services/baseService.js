import axios from 'axios';
import config from '../config';

let server = axios.create();

/**
 * @var {string} baseUrl
 */
class BaseService {
    constructor(baseUrl) {
        this.baseUrl = [
            config.apiUrl,
            baseUrl
        ].map(function (value) {
            return value
                .replace(/^\/+/, '')
                .replace(/\/+$/, '');
        }).join('/');
    }

    all() {
        return server.get(this.baseUrl);
    }

    get(id) {
        return server.get([this.baseUrl, id].join('/'));
    }

    save(item) {
        if (item.id) {
            return server.put([this.baseUrl, item.id].join('/'), item);
        }

        return server.post(this.baseUrl, item);
    }

    delete(item) {
        if (item.id) {
            item = item.id;
        }

        return server.delete([this.baseUrl, item].join('/'));
    }
}

export default BaseService;
