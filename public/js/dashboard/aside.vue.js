var TendooAsideMenu     =   new Vue({
    el          :   "#tendoo-aside-menu",
    methods     :   {
        /**
         * Toggle Menu
         * @param object
         * @return void
         */
        toggle( window, event ) {
            let element     =   window.document.activeElement;
            let parent      =   $( element ).closest( 'li' );
            let hasSubMenu  =   $( parent ).find( 'ul' ).length > 0;

            /**
             * Close all other menus
             */
            $( '#tendoo-aside-menu li' ).each( function(){
                $( this ).removeClass( 'active-menu' );
                $( this ).find( '.arrow' ).html( 'keyboard_arrow_down' );
            })

            if ( hasSubMenu ) {
                $( parent ).toggleClass( 'active-menu' );

                if ( $( parent ).hasClass( 'active-menu' ) ) {
                    $( parent ).find( '.arrow' ).html( 'keyboard_arrow_up' );
                } else {
                    $( parent ).find( '.arrow' ).html( 'keyboard_arrow_down' );
                }

                event.preventDefault();
            }
        } 
    },
    mounted() {
        
    }
});