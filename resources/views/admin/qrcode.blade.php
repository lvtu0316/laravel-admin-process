<div class="visible-print text-center">
    {{--{!! QrCode::format('png')->size(400)->errorCorrection('H')->backgroundColor(255,255,0)->color(2,4,153)->generate('Make me into a QrCode!'); !!}--}}
    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(400)->backgroundColor(255,255,0)->color(2,4,153)
    ->merge('/logo.png')->save('body.png')); !!} ">
    <p>Scan me to return to the original page.</p>
</div>