<?php
    /**
     * 
     * Handle custom post type messages
     * 
     */
    class BDTWTS_message {
        
        public function bulk_post_updated_messages_filter( $bulk_messages, $bulk_counts ) {
            $bulk_messages['tribute_widget'] = array(
                'updated'   => __( '%s Widget updated.', '%s Widgets updated.', $bulk_counts['updated'] ),
                'locked'    => __( '%s Widget not updated, somebody is editing it.', '%s Widgets not updated, somebody is editing them.', $bulk_counts['locked'] ),
                'deleted'   => __( '%s Widget permanently deleted.', '%s Widgets permanently deleted.', $bulk_counts['deleted'] ),
                'trashed'   => __( '%s Widget moved to the Trash.', '%s Widgets moved to the Trash.', $bulk_counts['trashed'] ),
                'untrashed' => __( '%s Widget restored from the Trash.', '%s Widgets restored from the Trash.', $bulk_counts['untrashed'] ),
            );
            return $bulk_messages;
        }
    }