<form (ngSubmit)="addCommand()" #commandForm="ngForm">
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-default">
            <tr>
                <th></th>
                <th>Command</th>
                <th>Action</th>
                <th>Replies To User</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr *ngFor="#command of commands">
                <td></td>
                <td>@{{ command.command }}</td>
                <td>@{{ command.action }}</td>
                <td>@{{ command.reply ? 'Yes' : 'No' }}</td>
                <td>
                    <button class="btn btn-danger btn-sm" type="button" (click)="deleteCommand(command)" *ngIf="command.deletable">
                        <span class="sr-only">Delete Command </span><span class="fa fa-times"></span>
                    </button>
                </td>
            </tr>
            <tr *ngIf="addFormActive">
                <td style="text-align:center;">
                    <button class="btn btn-primary btn-sm" type="submit" [disabled]="!commandForm.form.valid">
                        <span class="sr-only">Add Command </span><span class="fa fa-plus"></span>
                    </button>
                </td>
                <td>
                    <input type="text" class="form-control" placeholder="!newCommand" required [(ngModel)]="newCommand.command" (ngModelChange)="cleanCommand($event)" ngControl="command" #command="ngForm">
                    <div class="alert alert-danger" [hidden]="command.valid || command.pristine">Command is required.</div>
                </td>
                <td>
                    <textarea class="form-control" rows="1" placeholder="Text to display." required [(ngModel)]="newCommand.action" ngControl="action" #action="ngForm"></textarea>
                    <div class="alert alert-danger" [hidden]="action.valid || action.pristine">Action is required.</div>
                </td>
                <td>
                    <input type="checkbox" [(ngModel)]="newCommand.reply" ngControl="reply">
                </td>
                <td><input type="hidden" [(ngModel)]="newCommand.deletable" ngControl="deletable"></td>
            </tr>
        </tbody>
    </table>
</form>
