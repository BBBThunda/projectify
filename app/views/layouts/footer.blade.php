</div>
<div class="panel text-center">
    <p>&copy;2014 Bobby Cahill</p>
</div>

{{-- Include libraries from CDN if live, else use local files --}}
@if ($app->env == 'live')

<!-- jQuery and Bootstrap scripts from CDN -->
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

@else

<script src="/script/jquery-1.11.1.min.js"></script>
<script src="/script/bootstrap.min.js"></script>

@endif

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="/script/ie10-viewport-bug-workaround.js"></script>

<!-- Custom JS for entire site -->
<script src="/script/project.js"></script>
