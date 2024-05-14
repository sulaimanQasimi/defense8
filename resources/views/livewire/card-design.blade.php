<div>

    @includeWhen($cardFrame->dim === 'horizontal', 'livewire.card-design-horizontal')
    
    @includeWhen($cardFrame->dim == 'vertical', 'livewire.card-design-vertical')

</div>
