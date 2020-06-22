@component('mail::message')
# Description

{{ $report }}

@component('mail::button', ['url' => $reportUrl])
View Report
@endcomponent

@if ($imageUrl)
Image Link: <span>{{ $imageUrl }}</span>
@endif

@if ($videoUrl) 
Video Link:<span>{{ $videoUrl }}</span>
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
