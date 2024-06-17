<?php

if ( class_exists( 'Tribe__Events__Meta__Save' ) && ! class_exists( 'Ethos_Events_Meta_Save' ) ) {
    class Ethos_Events_Meta_Save extends \Tribe__Events__Meta__Save {

        /**
         * Custom save method to handle additional metadata.
         *
         * @return bool `true` if event meta was updated, `false` otherwise.
         */
        public function save() {
            if ( ! $this->context->has_nonce() ) {
                return false;
            }

            if ( ! $this->context->verify_nonce() ) {
                return false;
            }

            $_POST['Organizer'] = isset( $_POST['organizer'] ) ? stripslashes_deep( $_POST['organizer'] ) : null;
            $_POST['Venue']     = isset( $_POST['venue'] ) ? stripslashes_deep( $_POST['venue'] ) : null;

            /**
             * Handle previewed venues and organizers.
             */
            $this->manage_preview_metapost( 'venue', $this->post_id );
            $this->manage_preview_metapost( 'organizer', $this->post_id );

            // Save event meta using the original method
            \Tribe__Events__API::saveEventMeta( $this->post_id, $_POST, $this->post );

            return true;
        }
    }
}
