<table class="table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th>
                <button class="btn btn-info" (click)="showCreateSchedule()">
                    <span class="sr-only">Create Schedule</span><span class="fa fa-plus"></span>
                </button>
            </th>
            <th>Name</th>
            <th>Start At</th>
            <th>Repeat</th>
            <th># of times</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr *ngFor="#schedule of schedules">
            <td>
                <button class="btn btn-default" (click)="showEditSchedule(schedule)">
                    <span class="sr-only">View/Edit Schedule</span><span class="fa fa-edit"></span>
                </button>
            </td>
            <td>@{{ schedule.name }}</td>
            <td>@{{ schedule.getStartAt() }}</td>
            <td>@{{ schedule.repeat }}</td>
            <td>@{{ schedule.repeat_count }}</td>
            <td></td>
        </tr>
    </tbody>
</table>
