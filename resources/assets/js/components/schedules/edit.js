import CreateSchedule from './create';

class EditSchedule extends CreateSchedule {
    componentDidMount() {
        this.scheduleService.get(this.props.params.scheduleId).then((response) => {
            let data = response.data.data;

            this.setState({
                id:          data.id,
                name:        data.name,
                repeat:      data.repeat,
                repeatCount: data.repeat_count,
                startAt:     new Date(data.start_at * 1000),
                messages:    data.messages.data
            });
        });
    }
}

export default EditSchedule;
