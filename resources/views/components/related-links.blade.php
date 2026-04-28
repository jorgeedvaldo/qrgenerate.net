{{-- Related Links Component --}}
@props(['title', 'links', 'style' => 'list'])

@if(!empty($links) && count($links) > 0)
    <div class="article-section related-links" style="margin-top: 40px;">
        <h2 style="font-size: 24px; margin-bottom: 20px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">{{ $title }}</h2>
        
        @if($style === 'grid')
            <div class="row">
                @foreach($links as $link)
                    <div class="col-md-4 col-sm-6" style="margin-bottom: 15px;">
                        <a href="{{ url($link['url']) }}" style="display: flex; align-items: center; padding: 12px 15px; background: #f9f9f9; border-radius: 6px; border: 1px solid #eee; text-decoration: none; color: #333; transition: all 0.2s;">
                            @if(!empty($link['icon']))
                                <span class="glyphicon glyphicon-{{ $link['icon'] }}" style="color: #7b4397; margin-right: 12px; font-size: 18px;"></span>
                            @else
                                <span class="glyphicon glyphicon-link" style="color: #ccc; margin-right: 12px; font-size: 14px;"></span>
                            @endif
                            <span style="font-weight: 500;">{{ $link['title'] }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
            <style>
                .related-links .row a:hover {
                    background: #f0e6f5 !important;
                    border-color: #d1bfe0 !important;
                }
            </style>
        @else
            <ul style="list-style-type: none; padding-left: 0;">
                @foreach($links as $link)
                    <li style="margin-bottom: 10px;">
                        <span class="glyphicon glyphicon-chevron-right" style="color: #7b4397; font-size: 10px; margin-right: 8px;"></span>
                        <a href="{{ url($link['url']) }}" style="color: #5b287a; font-size: 16px; font-weight: 500;">{{ $link['title'] }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endif
