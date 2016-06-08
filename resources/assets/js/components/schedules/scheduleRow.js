import React, {Component} from 'react';
import {Link} from 'react-router';
import moment from 'moment';

class ScheduleRow extends Component {
    render() {
        let startAt = moment.unix(this.props.start_at),
            startAtString = startAt.format('L LT');

        return (
            <tr>
                <td>{this.renderDeleteButton()}</td>
                <td>{this.props.name}</td>
                <td>{startAtString}</td>
                <td>{this.props.repeat}</td>
                <td>{this.props.repeat_count}</td>
                <td>{this.renderEditButton()}</td>
            </tr>
        );
    }

    renderEditButton() {
        return (
            <Link className="btn btn-info btn-sm" to={`/schedules/${this.props.id}`}>
                <span className="sr-only">Edit Schedule</span>
                <span className="fa fa-pencil"/>
            </Link>
        );
    }

    renderDeleteButton() {
        return (
            <button className="btn btn-danger btn-sm" type="button">
                <span className="sr-only">Delete Schedule</span>
                <span className="fa fa-times"/>
            </button>
        );
    }
}

export default ScheduleRow;
