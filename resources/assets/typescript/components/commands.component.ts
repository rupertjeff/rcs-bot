/**
 * Created by jeffr on 2016-03-31.
 */

import {Component, OnInit} from 'angular2/core';
import {HTTP_PROVIDERS} from 'angular2/http';
import {CommandService} from './../services/commands.service';
import {Command} from './../objects/command';

@Component({
    selector: '#command-listing',
    templateUrl: '/api/templates/commands/listing',
    providers: [CommandService, HTTP_PROVIDERS]
})
export class CommandComponent implements OnInit {
    commands: Command[];
    errorMessage: string;

    constructor(private _commandService: CommandService) {}

    getCommands() {
        this._commandService.getCommands().subscribe(
            commands => this.commands = commands,
            error => this.errorMessage = <any>error
        );
    }

    ngOnInit() {
        this.getCommands();
    }
}
