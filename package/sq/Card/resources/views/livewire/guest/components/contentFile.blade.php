    <img src="{{ asset('logo.png') }}" class="absolute"
        :style="{ top: attr.profile.y + 'px', left: attr.profile.x + 'px', height: attr.profile.size + 'px' }" />

    <img :src="'/storage/' + attr.signature.path" class="absolute" style="z-index: 100"
        :style="{ top: attr.signature.y + 'px', left: attr.signature.x + 'px', height: attr.signature.size + 'px' }" />

    <div id="qrcode" style="position: absolute;" x-ref="qrcode"
        :style="{ top: attr.qrcode.y + 'px', left: attr.qrcode.x + 'px', height: attr.qrcode.size + 'px' }" />
    </div>

    <div style="position: absolute;" :style="{ top: attr.barCode.y + 'px', left: attr.barCode.x + 'px' }">
        <svg id="barcode"></svg>
    </div>
