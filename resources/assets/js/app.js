import React from 'react';
import ReactDOM from 'react-dom';
import {Router, Route, browserHistory} from 'react-router';
import Layout from './components/layout';
import Commands from './components/commands';

ReactDOM.render(
    <Router history={browserHistory}>
        <Route path="/" component={Layout}>
            <Route path="/commands" component={Commands}/>
        </Route>
    </Router>,
    document.getElementById('main-app')
);
