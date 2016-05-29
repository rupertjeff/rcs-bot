<form (ngSubmit)="saveCommand()" #commandForm="ngForm">
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-default">
            <tr>
                <th></th>
                <th>Command</th>
                <th>Action</th>
                <th>Replies To User</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr *ngFor="#cmd of commands">
                <td>
                    @{{ editFormActive ? 'On' : 'Off' }}
                    <button class="btn btn-info btn-sm" type="button" (click)="editCommand(cmd)" *ngIf=" ! editFormActive">
                        <span class="sr-only">Edit Command </span><span class="fa fa-pencil"></span>
                    </button>
                    <button class="btn btn-warning btn-sm" type="button" (click)="cancelEditCommand()" *ngIf="isEditingCommand(cmd)">
                        <span class="sr-only">Cancel Edit</span><span class="fa fa-times"></span>
                    </button>
                </td>
                <td *ngIf=" ! isEditingCommand(cmd)">@{{ cmd.command }}</td>
                <td *ngIf="isEditingCommand(cmd)">
                    <input type="text" class="form-control" placeholder="!command" required [(ngModel)]="cmd.command" (ngModelChange)="cmd.command=cleanCommand($event)" ngControl="command" #command="ngForm">
                </td>
                <td *ngIf=" ! isEditingCommand(cmd)">@{{ cmd.action }}</td>
                <td *ngIf="isEditingCommand(cmd)">
                    <textarea class="form-control" rows="1" placeholder="Text to display." required [(ngModel)]="cmd.action" ngControl="action" #action="ngForm"></textarea>
                </td>
                <td *ngIf=" ! isEditingCommand(cmd)">@{{ cmd.reply ? 'Yes' : 'No' }}</td>
                <td *ngIf="isEditingCommand(cmd)">
                    <input type="checkbox" [(ngModel)]="cmd.reply" ngControl="reply" #reply="ngForm">
                </td>
                <td>
                    <button class="btn btn-danger btn-sm" type="button" (click)="deleteCommand(cmd)" *ngIf=" ! isEditingCommand(cmd)">
                        <span class="sr-only">Delete Command </span><span class="fa fa-times"></span>
                    </button>
                    <button class="btn btn-success btn-sm" type="submit" [disabled]="!commandForm.form.valid" *ngIf="isEditingCommand(cmd)">
                        <span class="sr-only">Save Command </span><span class="fa fa-check"></span>
                    </button>
                </td>
            </tr>
            <tr *ngIf="addFormActive && ! editFormActive">
                <td style="text-align:center;">
                    <button class="btn btn-primary btn-sm" type="submit" [disabled]="!commandForm.form.valid">
                        <span class="sr-only">Add Command </span><span class="fa fa-plus"></span>
                    </button>
                </td>
                <td>
                    <input type="text" class="form-control" placeholder="!newCommand" required [(ngModel)]="newCommand.command" (ngModelChange)="newCommand.command=cleanCommand($event)" ngControl="command" #command="ngForm">
                    <div class="alert alert-danger" [hidden]="command.valid || command.pristine">Command is required.</div>
                </td>
                <td>
                    <textarea class="form-control" rows="1" placeholder="Text to display." required [(ngModel)]="newCommand.action" ngControl="action" #action="ngForm"></textarea>
                    <div class="alert alert-danger" [hidden]="action.valid || action.pristine">Action is required.</div>
                </td>
                <td>
                    <input type="checkbox" [(ngModel)]="newCommand.reply" ngControl="reply" #reply="ngForm">
                </td>
                <td>
                </td>
            </tr>
        </tbody>
    </table>
</form>
