<label for="schedule-script">Script</label>
<select class="form-control" id="schedule-script" required [(ngModel)]="script.id">
    <option *ngFor="#option of scripts" [value]="option.id">@{{ option.name }}</option>
</select>
