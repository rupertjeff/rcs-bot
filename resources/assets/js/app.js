/**
 * Name: app.js
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-31
 * Last Modified: 2016-03-31
 */

;(function (app, ng) {
    app.CommandService = (function () {
        var CommandService        = function (http) {
            this.url  = 'api/commands';
            this.http = http;
        };
        CommandService.parameters = [
            ng.http.Http
        ];

        CommandService.prototype.all = function () {
            return this.http.get(this.url)
                .map(function (response) {
                    return response.json().data;
                })
                .catch();
        };

        CommandService.prototype.create = function (command) {
            var body    = JSON.stringify(command);
            var options = {
                headers: {
                    'Content-Type': 'application/json'
                }
            };

            return this.http.post(this.url, body, options)
                .map(function (response) {
                    return response.json().data;
                })
                .catch();
        };

        CommandService.prototype.delete = function (command) {
            return this.http.delete([this.url, command.id].join('/'))
                .map(function (response) {
                    return response.json().data;
                })
                .catch();
        };

        return CommandService;
    })();
})(window.app || (window.app = {}), window.ng);

// CommandComponent for CRUD on bot commands
;(function (app, ng) {
    app.CommandComponent = (function () {
        function CommandComponent(commandService) {
            this.commandService = commandService;
            this.commands       = [];
            this.newCommand     = {
                command:    '',
                action:     '',
                reply:      false,
                deleteable: true
            };
            this.addFormActive  = true;
        }

        CommandComponent.parameters  = [
            app.CommandService
        ];
        CommandComponent.annotations = [
            new ng.core.Component({
                selector:    '#command-listing',
                templateUrl: 'api/templates/commands/listing',
                providers:   [
                    app.CommandService,
                    ng.http.HTTP_PROVIDERS
                ]
            })
        ];

        CommandComponent.prototype.all = function () {
            var self = this;

            this.commandService.all().subscribe(
                function (commands) {
                    self.commands = commands;
                }, function (error) {
                    self.error = error;
                }
            );
        };

        CommandComponent.prototype.ngOnInit = function () {
            this.all();
        };

        CommandComponent.prototype.cleanCommand = function (value) {
            value = value.replace(/[^a-z]+/gi, '');

            if (0 >= value.indexOf('!') && '!' !== value.substr(0, 1)) {
                value = '!' + value;
            }

            this.newCommand.command = value;
        };

        CommandComponent.prototype.addCommand = function () {
            var self = this;

            this.commands.push(this.newCommand);
            this.commandService.create(this.newCommand).subscribe(
                function (command) {
                    self.all();
                }, function (error) {
                    self.all();
                }
            );

            this.resetTemporaryCommand();
            this.addFormActive = false;
            setTimeout(function () {
                self.addFormActive = true;
            }, 1);
        };

        CommandComponent.prototype.resetTemporaryCommand = function () {
            this.newCommand = {
                command:   '',
                action:    '',
                reply:     false,
                deletable: true
            };
        };

        CommandComponent.prototype.deleteCommand = function (command) {
            var self    = this;
            var indexOf = this.commands.indexOf(command);
            var newList = this.commands.slice(0, indexOf);

            this.commands = newList.concat(this.commands.slice(indexOf + 1));
            this.commandService.delete(command).subscribe(
                function (command) {
                    self.all();
                }, function (error) {
                    self.all();
                }
            );
        };

        return CommandComponent;
    })();
})(window.app || (window.app = {}), window.ng);

// Associate the component to the DOM
;(function (app, ng) {
    document.addEventListener('DOMContentLoaded', function () {
        ng.platform.browser.bootstrap(app.CommandComponent);
    });
})(window.app || (window.app = {}), window.ng);
