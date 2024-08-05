<?php
add_action('init', function (){
    if(str_starts_with($_SERVER['REQUEST_URI'], '/conteudo/inscricao-evento')) {
        global $wpdb;
        if(isset($_GET['id']) && is_numeric($_GET['id'])) {
            $event_id = (int) $_GET['id'];
            
            $sql = "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_ethos_crm:fut_pf_id' AND meta_value = %d";
            
            // procura no banco de dados o post pelo id do evento que está no metadado _ethos_crm:fut_pf_id
            if($post_id = $wpdb->get_var($wpdb->prepare($sql, $event_id))){
                unset($_GET['id']);
                if($query_vars = http_build_query($_GET)){
                    $query_vars = "?{$query_vars}";
                }
                wp_redirect(get_permalink($post_id) . "{$query_vars}", 301);
                die;
            }
    
        }
    }

    if(str_starts_with($_SERVER['REQUEST_URI'], '/conteudo/certificado-evento')) {
        global $wpdb;
        if(isset($_GET['id']) && is_numeric($_GET['id'])) {
            $event_id = (int) $_GET['id'];
            
            $sql = "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_ethos_crm:fut_pf_id' AND meta_value = %d";
            
            // procura no banco de dados o post pelo id do evento que está no metadado _ethos_crm:fut_pf_id
            if($post_id = $wpdb->get_var($wpdb->prepare($sql, $event_id))){
                wp_redirect(get_permalink($post_id) . "?certificado", 301);
                die;
            }
    
        }
    }
});
