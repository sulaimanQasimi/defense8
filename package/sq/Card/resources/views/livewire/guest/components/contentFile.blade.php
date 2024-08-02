<div>
    <img src="{{ asset('logo.png') }}" class="absolute"
        :style="{ top: attr.profile.y + 'px', left: attr.profile.x + 'px', height: attr.profile.size + 'px' }" />
</div>
<div id="qrcode" style="position: absolute;"  x-ref="qrcode"
    :style="{ top: attr.qrcode.y + 'px', left: attr.qrcode.x + 'px', height: attr.qrcode.size + 'px' }" />
</div>
