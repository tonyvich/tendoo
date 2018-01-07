var TendooTable     =   new Vue({
    el      :   '#tendoo-table',
    data    :   {
        columns     :   table.columns,
        entries     :   [],
        actions     :   [],
        url         :   table.url
    },
    methods: {
        /**
         * delete
         * @param int entry id
         * @return void
         */
        deleteEntry( entryId, event ) {
            let element     =   $( event )[0].srcElement;
            let parent      =   $( element ).closest( 'tr' );
            
            axios({
                method  :   'delete',
                url     :   $( element ).attr( 'data-url' )
            }).then( ( content ) => {
                $( parent ).fadeOut(500, function() {
                    $( this ).remove();
                })
            }, ( content ) => {
                $( parent ).fadeOut(500, function() {
                    $( this ).remove();
                })
            })
        },

        /**
         * Load entries
         * @param void
         * @return void
         */
        loadEntries() {
            axios({
                url     :   this.url
            }).then( result => {
                this.entries    =   result.data.entries;
            })
        }
    },
    mounted() {
        this.loadEntries();
    }
})