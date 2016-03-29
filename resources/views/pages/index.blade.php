@if (session()->has('status')){{ session('status') }}@endif
<a href="/postMessage" id="post-message">Post Message</a>

<form method="post" action="/sendCustomMessage">
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    <input type="text" name="message"/>
    <button type="submit" id="submit-custom-message">Submit</button>
</form>
