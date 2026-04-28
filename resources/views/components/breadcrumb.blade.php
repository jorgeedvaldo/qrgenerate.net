{{-- Breadcrumb Component
     Usage: @include('components.breadcrumb', ['items' => [['label' => 'Home', 'url' => '/'], ['label' => 'Current Page']]])
     The last item is automatically rendered as active (no link).
--}}

@if(!empty($items))
<ol class="breadcrumb">
    @foreach($items as $item)
        @if($loop->last)
            <li class="active">{{ $item['label'] }}</li>
        @else
            <li><a href="{{ $item['url'] ?? '#' }}">{{ $item['label'] }}</a></li>
        @endif
    @endforeach
</ol>
@endif
