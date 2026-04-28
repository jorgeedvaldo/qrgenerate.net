{{-- FAQ Component
     Usage: @include('components.faq', ['faqs' => [...], 'locale' => 'en'])
     Renders an SEO-friendly FAQ section with JSON-LD FAQPage schema.
--}}

@if(!empty($faqs))
<div class="article-section" id="faq">
    <h2>{{ ($locale ?? 'en') === 'pt' ? 'Perguntas Frequentes' : 'Frequently Asked Questions' }}</h2>

    <div class="panel-group" id="faq-accordion" role="tablist" aria-multiselectable="true">
        @foreach($faqs as $i => $faq)
        <div class="panel panel-purple">
            <div class="panel-heading" role="tab" id="faq-heading-{{ $i }}">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#faq-accordion"
                       href="#faq-collapse-{{ $i }}" aria-expanded="{{ $i === 0 ? 'true' : 'false' }}"
                       aria-controls="faq-collapse-{{ $i }}">
                        {{ $faq['question'] }}
                    </a>
                </h4>
            </div>
            <div id="faq-collapse-{{ $i }}" class="panel-collapse collapse {{ $i === 0 ? 'in' : '' }}"
                 role="tabpanel" aria-labelledby="faq-heading-{{ $i }}">
                <div class="panel-body">
                    {!! $faq['answer'] !!}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- FAQ JSON-LD Schema --}}
@php
$faqSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(function ($faq) {
        return [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => strip_tags($faq['answer']),
            ],
        ];
    }, $faqs),
];
@endphp
<script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}</script>
@endif
