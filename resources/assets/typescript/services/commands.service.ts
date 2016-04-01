/**
 * Created by jeffr on 2016-03-31.
 */

import {Injectable} from 'angular2/core';
import {Http, Response} from 'angular2/http';
import {Command} from './../objects/command';
import {Observable} from 'rxjs/Observable';

@Injectable()
export class CommandService {
    private url = 'api/commands';

    constructor(private http:Http) {
    }

    getCommands() {
        return this.http.get(this.url)
            .map(res => <Command[]> res.json().data)
            .catch(this.handleError);
    }

    private handleError(error:Response) {
        return Observable.throw(error.json().error || 'Server error');
    }
}
