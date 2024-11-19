<?php

class AYS_Gall_Main_List_Table extends WP_List_Table{
	public static function define_columns() {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title', 'ays_gallery' ),
			'shortcode' => __('Shortcode','ays_gallery'),
			'id' => __( 'ID', 'ays_gallery' ) 
		);
		return $columns;
	}
	function __construct() {
		parent::__construct();
	}
	function get_columns(){
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title', 'ays_gallery' ),
			'shortcode' => __('Shortcode','ays_gallery'),
			'id' => __( 'ID', 'ays_gallery' ) 
		);
		return $columns;		
    }
	function prepare_items() {
		$current_screen = get_current_screen();
		$columns = $this->define_columns();
		$hidden = array();
		$sortable =  $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);

		if ( ! empty( $_REQUEST['s'] ) )
			$args['s'] = $_REQUEST['s'];

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			if ( 'title' == $_REQUEST['orderby'] )
				$args['orderby'] = 'title';
			elseif ( 'id' == $_REQUEST['orderby'] )
				$args['orderby'] = 'id';
		}

		if ( ! empty( $_REQUEST['order'] ) ) {
			if ( 'asc' == strtolower( $_REQUEST['order'] ) )
				$args['order'] = 'ASC';
			elseif ( 'desc' == strtolower( $_REQUEST['order'] ) )
				$args['order'] = 'DESC';
		}
                
                /** Process bulk action */
                $this->process_bulk_action();
                
		$this->items = AYS_Gall_Main::find( $args );	
		$per_page = $this->get_items_per_page( 'ays_ays_id_per_page', 5 );
	
		$current_page = $this->get_pagenum();
		$total_items = count($this->items);
		$total_pages = ceil( $total_items / $per_page );

		$ays_nk_data = array_slice($this->items,(($current_page-1)*$per_page),$per_page);

		$this->set_pagination_args( array(
		'total_items' => $total_items,            
		'per_page'    => $per_page                    
		) );

		$this->items = $ays_nk_data;		
	}
	function get_sortable_columns() {
		$columns = array(
			'title' => array( 'title', true ),
			'shortcode' => array( 'shortcode', false ),
			'id' => array( 'id', true ) 
		);

		return $columns;
	}
	function get_bulk_actions() {
		$actions = array(
			'delete' => __( 'Delete', 'ays_gallery' ) );
		return $actions;
	}
	function column_default( $item, $column_name ) {
		return '';
        }
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="ays_id[]" value="%s" />',
			$item->id );
	}
	function column_title( $item ) {
		$url = admin_url( 'admin.php?page=ays_gall_main&gall_id='.$item->id );
		$edit_link = add_query_arg( array( 'action' => 'edit' ), $url );

		$actions = array(
			'edit' => '<a href="' . $edit_link . '">' . __( 'Edit', 'ays_gallery' ) . '</a>' );
			$a = sprintf( '<a class="row-title" href="%1$s" title="%2$s">%3$s</a>',
			$edit_link,
			esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;', 'ays_gallery' ),
				$item->title ) ),
			esc_html( $item->title ) 
		);
		return '<strong>' . $a . '</strong> ' . $this->row_actions( $actions );
    }
	function column_shortcode( $item ) {
		return sprintf('<input type="text" onClick="this.setSelectionRange(0, this.value.length)" readonly value="[gallery_p_gallery id=%s]" />',$item->id);
    }
	function column_id( $item ) {
		$ids = array((int)$item->id);
		return (int)$item->id;
	}
    public function process_bulk_action() {

        // security check!
        if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

            $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
            $action = 'bulk-' . $this->_args['ays_gallery'];

            if ( ! wp_verify_nonce( $nonce, $action ) )
                wp_die( 'Nope! Security check failed!' );

        }

        $action = $this->current_action();

        switch ( $action ) {
            case 'delete':
                $ays_ids = empty( $_POST['post_id'] )
                        ? (array) $_REQUEST['ays_id']
                        : (array) $_POST['post_id'];

                $deleted = 0;
                foreach ( $ays_ids as $ays_id ) {
                        $ays_del = AYS_Gall_Main::get_instance( $ays_id );
                        if ( empty( $ays_del ) )
                                continue;
                        	var_dump($ays_del);
                        	exit();
                        $ays_del ->delete();
                        $deleted += 1;
                }

                $query = array();
                if ( ! empty( $deleted ) )
                        $query['message'] = 'deleted';
                $_REQUEST["message"] = 'deleted';
                $redirect_to = add_query_arg( $query, '?page=ays_gall_main' );
                break;
            default:
                return;
                break;
        }

        return;
    }
}