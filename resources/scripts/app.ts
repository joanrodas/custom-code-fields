import Alpine from 'alpinejs';

window.addEventListener( 'DOMContentLoaded', () => {
    Alpine.data( 'initSection', ( product_id ) => ( {
        init()
        {

            fetch( CPF_PARAMS.api_url + '/getFields/' + product_id,
              {
                  // eslint-disable-line
                  method: 'GET',
                  mode: 'cors',
                  credentials: 'same-origin',
                  redirect: 'follow',
                  referrerPolicy: 'no-referrer',
                  headers: {
                      'X-WP-Nonce': CPF_PARAMS.restNonce, // eslint-disable-line
                  }
              }
            ).then(response => response.json())
            .then( ( response ) => {
              this.section_fields = response.fields;
            } );

        },
        section_fields: []
    } ) );

    window.Alpine = Alpine;
    Alpine.start();
} );
