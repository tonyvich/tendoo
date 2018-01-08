@extends( 'components.backend.dashboard.master' )
@section( 'components.backend.dashboard.master.body' )
    <div id="hero-js-select" class="mdc-select" role="listbox" tabindex="0">
        <div class="mdc-select__surface">
            <div class="mdc-select__label">Pick a Food Group</div>
            <div class="mdc-select__selected-text"></div>
            <div class="mdc-select__bottom-line"></div>
        </div>
        <div class="mdc-simple-menu mdc-select__menu">
            <ul class="mdc-list mdc-simple-menu__items">
                <li class="mdc-list-item" role="option" tabindex="0">
                    Bread, Cereal, Rice, and Pasta
                </li>
                <li class="mdc-list-item" role="option" aria-disabled="true" tabindex="0">
                    Vegetables
                </li>
                <li class="mdc-list-item" role="option" tabindex="0">
                    Fruit
                </li>
                <li class="mdc-list-item" role="option" tabindex="0">
                    Milk, Yogurt, and Cheese
                </li>
                <li class="mdc-list-item" role="option" tabindex="0">
                    Meat, Poultry, Fish, Dry Beans, Eggs, and Nuts
                </li>
                <li class="mdc-list-item" role="option" tabindex="0">
                    Fats, Oils, and Sweets
                </li>
            </ul>
        </div>
    </div>
    <script>
    jQuery( document ).ready( function(){
        var MDCSelect = mdc.select.MDCSelect;
        var heroSelect = document.getElementById('hero-js-select');
        var heroSelectComponent = new mdc.select.MDCSelect(heroSelect);
        heroSelectComponent.listen( 'MDCSelect:change', () => {
            console.log( heroSelectComponent );
        })
    });
    </script>
@endsection