import moment from 'moment';
import CreateSchedule from './create';

class EditSchedule extends CreateSchedule {
    componentDidMount() {
        this.scheduleService.get(this.props.params.scheduleId).then((response) => {
            let data = response.data.data,
                startAt = moment.unix(data.start_at),
                startAtString = startAt.format('L LT');
            
            this.setState({
                id:          data.id,
                name:        data.name,
                repeat:      data.repeat,
                repeatCount: data.repeat_count,
                startAt:     startAtString,
                messages:    data.messages.data
            });
        });
    }
}

export default EditSchedule;
