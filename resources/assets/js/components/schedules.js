import React, {Component} from 'react';
import ScheduleService from '../services/schedule';
import ScheduleRow from './schedules/scheduleRow';
import {Link} from 'react-router';

class Schedules extends Component {
    constructor(props) {
        super(props);

        this.state           = {
            schedules: []
        };
        this.scheduleService = new ScheduleService;
    }

    componentDidMount() {
        this.loadSchedules();
    }

    loadSchedules() {
        this.scheduleService.all().then((response) => {
            this.setState({
                schedules: response.data.data
            });

            return Promise.resolve(response);
        });
    }

    render() {
        let scheduleRows = this.state.schedules.map(function (schedule, index) {
            return (
                <ScheduleRow
                    {...schedule}
                    key={schedule.id}
                    index={index}
                />
            );
        });
        return (
            <table className="table table-striped table-bordered table-hover">
                <thead className="thead-default">
                    <tr>
                        <th>
                            {this.renderCreateButton()}
                        </th>
                        <th>Name</th>
                        <th>Start At</th>
                        <th>Repeat</th>
                        <th># of Times</th>
                        <th/>
                    </tr>
                </thead>
                <tbody>
                    {scheduleRows}
                </tbody>
            </table>
        );
    }

    renderCreateButton() {
        return (
            <Link to="/schedules/create" className="btn btn-info btn-sm">
                <span className="sr-only">Create Schedule</span>
                <span className="fa fa-plus"/>
            </Link>
        );
    }
}

export default Schedules;
