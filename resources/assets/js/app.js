import React from 'react';
import ReactDOM from 'react-dom';
import {Router, Route, browserHistory} from 'react-router';
import Layout from './components/layout';
import Commands from './components/commands';
import Schedule from './components/schedules';
import CreateSchedule from './components/schedules/create';
import EditSchedule from './components/schedules/edit';

ReactDOM.render(
    <Router history={browserHistory}>
        <Route path="/" component={Layout}>
            <Route path="/commands" component={Commands}/>
            <Route path="/schedules" component={Schedule}/>
            <Route path="/schedules/create" component={CreateSchedule}/>
            <Route path="/schedules/:scheduleId" component={EditSchedule}/>
        </Route>
    </Router>,
    document.getElementById('main-app')
);
