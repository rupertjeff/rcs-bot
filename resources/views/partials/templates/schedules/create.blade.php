<form (click)="saveSchedule()" #scheduleForm="ngForm">
    <h1>Create Schedule</h1>
    <div class="form-group">
        <label class="sr-only" for="schedule-name">Schedule Name:</label>
        <input class="form-control" id="schedule-name" type="text" placeholder="Schedule Name" required [(ngModel)]="schedule.name" ngControl="name" #name="ngForm">
    </div>
    <div class="form-group">
        <label for="schedule-repeat" class="sr-only">Repeat Frequency:</label>
        <select class="form-control" id="schedule-repeat" required [(ngModel)]="schedule.repeat">
            <option *ngFor="#option of repeatOptions" [value]="option">@{{ option.ucwords() }}</option>
        </select>
    </div>
    <div class="form-group">
        <label for="schedule-repeat-count" class="sr-only">Times to Repeat:</label>
        <input class="form-control" id="schedule-repeat-count" type="number" placeholder="Times to Repeat" required [(ngModel)]="schedule.repeat_count" ngControl="repeat_count" #repeat_count="ngForm">
    </div>
    <div class="form-group">
        <label for="schedule-start-at" class="sr-only">Start Schedule At:</label>
        <input type="text" class="form-control" id="schedule-start-at" placeholder="Start At: mm/dd/yyyy hh:mm (24hr)" required [(ngModel)]="schedule.start_at" ngControl="start_at" #start_at="ngForm">
    </div>
    {{-- START Script Sub-Component -- TODO: Move all of this into a sub view. --}}
    <div class="script-component">
        <div class="form-group">
            <label for="schedule-script" class="sr-only">Script</label>
            <select class="form-control" id="schedule-script" required [(ngModel)]="schedule.script_id">
                <option value="0">Create New Script</option>
                <option *ngFor="#option of scripts" [value]="option.id">@{{ option.name }}</option>
            </select>
        </div>
        <table>
            <tbody>
                <tr *ngFor="#message of schedule.script.messages">
                    <td><input type="number" placeholder="xx" [(ngModel)]="message.offset"> minutes</td>
                    <td><input type="text" placeholder="Message body here" [(ngModel)]="message.content"></td>
                    <td><input type="text" placeholder="Message Name (optional)" [(ngModel)]="message.name"></td>
                    <td><button class="btn btn-danger" (click)="removeMessage(message)"><span class="fa fa-times"><span class="sr-only">Remove Message</span></span></button></td>
                </tr>
                <tr>
                    <td><input type="number" placeholder="xx" [(ngModel)]="newMessage.offset"> minutes</td>
                    <td><input type="text" placeholder="Message body here" [(ngModel)]="newMessage.content"></td>
                    <td><input type="text" placeholder="Message Name (optional)" [(ngModel)]="newMessage.name"></td>
                    <td><button class="btn btn-info" (click)="addMessage()"><span class="fa fa-check"><span class="sr-only">Add Message</span></span></button></td>
                </tr>
            </tbody>
        </table>
    </div>
    {{-- END Sub-Component --}}
    <div class="form-group form-actions">
        <button class="btn btn-warning" type="button" (click)="showListing()">
            <span class="fa fa-times"></span> Cancel
        </button>
        <button class="btn btn-success" type="submit">
            <span class="fa fa-check"></span> Save
        </button>
    </div>
</form>
