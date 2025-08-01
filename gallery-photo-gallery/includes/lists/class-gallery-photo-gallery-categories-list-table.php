<?php
ob_start();
class Gpg_Categories_List_Table extends WP_List_Table{
    private $plugin_name;
    private $title_length;
    /** Class constructor */
    public function __construct($plugin_name) {
        $this->plugin_name = $plugin_name;
        $this->title_length = Gallery_Photo_Gallery_Admin::get_gpg_listtables_title_length('image_categories');
        parent::__construct( array(
            'singular' => __( 'Image Category', 'gallery-photo-gallery' ), //singular name of the listed records
            'plural'   => __( 'Image Categories', 'gallery-photo-gallery' ), //plural name of the listed records
            'ajax'     => false //does this table support ajax?
        ) );
        add_action( 'admin_notices', array( $this, 'image_category_notices' ) );
    }
    
    /**
     * Retrieve customers data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed
     */
    public static function get_image_categories( $per_page = 20, $page_number = 1, $search = '' ) {

        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_gallery_categories";

        $where = array();

        if( $search != '' ){
            $where[] = $search;
        }

        if( ! empty($where) ){
            $sql .= " WHERE " . implode( " AND ", $where );
        }


        if ( ! empty( $_REQUEST['orderby'] ) ) {

            $order_by  = ( isset( $_REQUEST['orderby'] ) && sanitize_text_field( $_REQUEST['orderby'] ) != '' ) ? sanitize_text_field( $_REQUEST['orderby'] ) : 'ordering';
            $order_by .= ( ! empty( $_REQUEST['order'] ) && strtolower( $_REQUEST['order'] ) == 'asc' ) ? ' ASC' : ' DESC';

            $sql_orderby = sanitize_sql_orderby($order_by);

            if ( $sql_orderby ) {
                $sql .= ' ORDER BY ' . $sql_orderby;
            } else {
                $sql .= ' ORDER BY id DESC';
            }
        }else{
            $sql .= ' ORDER BY id DESC';
        }

        $sql .= " LIMIT $per_page";
        $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


        $result = $wpdb->get_results( $sql, 'ARRAY_A' );

        return $result;
    }

    public function get_gallery_category( $id ) {
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_gallery_categories WHERE id=" . absint( sanitize_text_field( $id ) );

        $result = $wpdb->get_row($sql, 'ARRAY_A');

        return $result;
    }

    public function add_edit_gallery_category( $data ){
        global $wpdb;
        $gpg_category_table = $wpdb->prefix . 'ays_gallery_categories';
        $ays_change_type = (isset($data['ays_change_type']))?$data['ays_change_type']:'';
        if( isset($data["gallery_category_action"]) && wp_verify_nonce( $data["gallery_category_action"],'gallery_category_action' ) ){
            $id = absint( intval( $data['id'] ) );
            $title = stripslashes(sanitize_text_field($data['ays_title']));
            $description =  stripslashes($data['ays_description']);
            $message = '';
            if( $id == 0 ){
                $result = $wpdb->insert(
                    $gpg_category_table,
                    array(
                        'title'         => $title,
                        'description'   => $description
                    ),
                    array( '%s', '%s' )
                );
                $message = 'created';
            }else{
                $result = $wpdb->update(
                    $gpg_category_table,
                    array(
                        'title'         => $title,
                        'description'   => $description
                    ),
                    array( 'id' => $id ),
                    array( '%s', '%s' ),
                    array( '%d' )
                );
                $message = 'updated';
            }

            if( $result >= 0  ) {
                if($ays_change_type != ''){
                    if($id == null){
                        $url = esc_url_raw( add_query_arg( array(
                            "action"    => "edit",
                            "gallery_category"  => $wpdb->insert_id,
                            "status"    => $message
                        ) ) );
                    }else{
                        $url = esc_url_raw( remove_query_arg(false) ) . '&status=' . $message;
                    }
                    wp_redirect( $url );
                }else{
                    $url = esc_url_raw( remove_query_arg(array('action', 'gallery_category')  ) ) . '&status=' . $message;
                    wp_redirect( $url );
                }
            }
        }
    }

    /**
     * Delete a customer record.
     *
     * @param int $id customer ID
     */
    public static function delete_image_categories( $id ) {
        global $wpdb;
        $wpdb->delete(
            "{$wpdb->prefix}ays_gallery_categories",
            array( 'id' => $id ),
            array( '%d' )
        );
    }


    /**
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    public static function record_count() {
        global $wpdb;

        $filter = array();

        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}ays_gallery_categories";

        $search = ( isset( $_REQUEST['s'] ) ) ? $_REQUEST['s'] : false;
        if( $search ){
            $filter[] = sprintf(" title LIKE '%%%s%%' ", $search );
        }
        
        if(count($filter) !== 0){
            $sql .= " WHERE ".implode(" AND ", $filter);
        }


        return $wpdb->get_var( $sql );
    }

    public static function all_record_count() {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}ays_gallery_categories";

        return $wpdb->get_var( $sql );
    }

   /* public static function published_quiz_categories_count() {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}aysquiz_quizcategories WHERE published=1";

        return $wpdb->get_var( $sql );
    }*/
  /*  
    public static function unpublished_quiz_categories_count() {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}aysquiz_quizcategories WHERE published=0";

        return $wpdb->get_var( $sql );
    }*/

    /** Text displayed when no customer data is available */
    public function no_items() {
        echo __( 'There are no image categories yet.', 'gallery-photo-gallery' );
    }


    /**
     * Render a column when no column specific method exist.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'title':
            case 'description':
                return Gallery_Photo_Gallery_Admin::ays_restriction_string("word",strip_tags($item[ $column_name ]), 15);
                break;
            case 'items_count':
            case 'id':
                return $item[ $column_name ];
                break;
            default:
                return print_r( $item, true ); //Show the whole array for troubleshooting purposes
        }
    }

    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    function column_cb( $item ) {
        
        // if(intval($item['id']) === 1){
        //     return;
        // }
        
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
        );
    }


    /**
     * Method for name column
     *
     * @param array $item an array of DB data
     *
     * @return string
     */
    function column_title( $item ) {
        $delete_nonce = wp_create_nonce( $this->plugin_name . '-delete-gallery-category' );

        $gallery_categories_title_length = intval( $this->title_length );

        $column_t = esc_attr( stripcslashes($item['title']) );
        $t = esc_attr($column_t);

        $restitle = Gallery_Photo_Gallery_Admin::ays_restriction_string("word", $column_t, $gallery_categories_title_length);
        $title = sprintf( '<a href="?page=%s&action=%s&gallery_category=%d" title="%s"><strong>%s</strong></a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['id'] ), $t, $restitle );        

        $actions = array(
            'edit' => sprintf( '<a href="?page=%s&action=%s&gallery_category=%d">'. __('Edit', 'gallery-photo-gallery') .'</a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['id'] ) ),
        );
        
        $actions['delete'] = sprintf( '<a class="ays_confirm_del" data-message="%s" href="?page=%s&action=%s&gallery_category=%s&_wpnonce=%s">'. __('Delete', 'gallery-photo-gallery') .'</a>', $restitle, esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce );

        return $title . $this->row_actions( $actions );
    }    

    function column_items_count( $item ) {
        global $wpdb;

        $result = 0;
        if( isset( $item['id'] ) && absint( sanitize_text_field( $item['id'] ) ) > 0){
            $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}ays_gallery WHERE categories_id = " . absint( sanitize_text_field($item['id'] ) );
            $result = $wpdb->get_var($sql);
        }

        return "<p style='text-align:center;font-size:14px;'>" . $result . "</p>";
    }


    /**
     *  Associative array of columns
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb'            => '<input type="checkbox" />',
            'title'         => __( 'Title', 'gallery-photo-gallery' ),
            'description'   => __( 'Description', 'gallery-photo-gallery' ),
            'id'            => __( 'ID', 'gallery-photo-gallery' ),
        );

        return $columns;
    }


    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'title'         => array( 'title', true ),
            'id'            => array( 'id', true ),
        );

        return $sortable_columns;
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions() {
        $actions = array(
            'bulk-delete' => __('Delete', 'gallery-photo-gallery')
        );

        return $actions;
    }


    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {

        $this->_column_headers = $this->get_column_info();

        /** Process bulk action */
        $this->process_bulk_action();

        $per_page     = $this->get_items_per_page( 'gallery_categories_per_page', 20 );
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();

        $this->set_pagination_args( array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page'    => $per_page //WE have to determine how many items to show on a page
        ) );


        $search = ( isset( $_REQUEST['s'] ) ) ? $_REQUEST['s'] : false;

        $do_search = ( $search ) ? sprintf(" title LIKE '%%%s%%' ", $search ) : '';


        $this->items = self::get_image_categories( $per_page, $current_page,$do_search );

    }

    public function process_bulk_action() {

        //Detect when a bulk action is being triggered...
        if ( 'delete' === $this->current_action() ) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );

            if ( ! wp_verify_nonce( $nonce, $this->plugin_name . '-delete-gallery-category' ) ) {
                die( 'Go get a life script kiddies' );
            }
            else {
                self::delete_image_categories( absint( $_GET['gallery_category'] ) );

                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url

                $url = esc_url_raw( remove_query_arg(array('action', 'gallery_category', '_wpnonce')  ) ) . '&status=deleted';
                wp_redirect( $url );
            }

        }

        // If the delete bulk action is triggered
        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' ) || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' ) ) {

            $delete_ids = ( isset( $_POST['bulk-delete'] ) && ! empty( $_POST['bulk-delete'] ) ) ? esc_sql( $_POST['bulk-delete'] ) : array();

            // loop over the array of record IDs and delete them
            foreach ( $delete_ids as $id ) {
                self::delete_image_categories( $id );

            }

            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url
            $url = esc_url_raw( remove_query_arg(array('action', 'gallery_category', '_wpnonce')  ) ) . '&status=deleted';
            wp_redirect( $url );
        }
    }



    public function image_category_notices(){
        $status = (isset($_REQUEST['status'])) ? sanitize_text_field( $_REQUEST['status'] ) : '';

        if ( empty( $status ) )
            return;

        if ( 'created' == $status )
            $updated_message = esc_html( __( 'Image category created.', 'gallery-photo-gallery' ) );
        elseif ( 'updated' == $status )
            $updated_message = esc_html( __( 'Image category saved.', 'gallery-photo-gallery' ) );
        elseif ( 'deleted' == $status )
            $updated_message = esc_html( __( 'Image category deleted.', 'gallery-photo-gallery' ) );

        if ( empty( $updated_message ) )
            return;

        ?>
            <div class="ays-gpg-admin-notice notice notice-success is-dismissible">
                <p> <?php echo $updated_message; ?> </p>
            </div>
        <?php
    }
}