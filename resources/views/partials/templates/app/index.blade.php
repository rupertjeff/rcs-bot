<header>
    <nav class="navbar navbar-fixed-top bg-inverse">
        <h1 class="navbar-brand">RCS Discord Bot</h1>
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link" [routerLink]="['Commands']">Commands</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" [routerLink]="['Schedules']">Schedules</a>
            </li>
        </ul>
    </nav>
</header>
<div class="container-fluid" style="padding-top: 3.375rem">
    <section class="row">
        <div class="col-xs-12">
            <router-outlet></router-outlet>
        </div>
    </section>
</div>
<footer>
    <div class="container">
        <p>Built by {!! link_to('https://twitter.com/jeffrupertmusic', 'Vexillarius') !!}</p>
    </div>
</footer>
