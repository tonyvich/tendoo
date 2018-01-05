var TendooTopBar    =   new Vue({
    el  :   '#main-nav',
    methods: {
        /**
         * Toggle Aside
         * @param void
         * @return void
         */
        toggle() {
            $( 'body > div' ).toggleClass( 'collapsed-aside' );
            $( 'body > div' ).toggleClass( 'expanded-aside' );
        }
    }
});