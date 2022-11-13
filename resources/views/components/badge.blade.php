{{ $show }}
@if (!isset($show) || $show == true)
    <span class="badge badge-{{ $type ?? 'success' }}">
        {{ $slot }}
    </span>
@endif
