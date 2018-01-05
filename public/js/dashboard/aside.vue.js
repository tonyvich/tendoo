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

            if ( hasSubMenu ) {
                $( parent ).toggleClass( 'active-menu' );
                event.preventDefault();
            }
        } 
    },
    mounted() {
        
    }
});