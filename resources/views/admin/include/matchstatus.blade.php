@if ($match->status == 0)
<span class="badge bg-primary">Match is not Started </span>
@elseif($match->status == 1)
<span class="badge live-watch">First Half </span>
@elseif($match->status == 2)
<span class="badge bg-warning">Break Time </span>
@elseif($match->status == 3)
<span class="badge live-watch">Second Half </span>
@else
<span class="badge bg-danger">Match End </span>
@endif