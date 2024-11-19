<?php
class AYS_Gall_Main{
    private static $current = null;
    private function __construct() {
        $this->setup_constants();
        add_action( 'admin_notices', array($this,'ays_gall_messages') );
    }    
    public function setup_constants() {
        if (!defined('AYS_GALL_DIR')) {
            define('AYS_GALL_DIR', dirname(__FILE__));
        }
        if (!defined('AYS_GALL_URL')) {
            define('AYS_GALL_URL', plugins_url(plugin_basename(dirname(__FILE__))));
        }
    }
    public static function find( $args = '' ) {
        global $wpdb;
        $defaults = array(
                'orderby' => 'id',
                'order' => 'ASC' );

        $args = wp_parse_args( $args, $defaults );

        $where = array();
        if( isset( $args['s'] ) )
                $where[] = isset( $args['s'] ) ? ' title LIKE "%'.$args['s'].'%"' : '';
        if( isset( $args['title'] ) && $args['title'] != '' )
                $where[] = isset( $args['title'] ) ? ' title = '.(int)$args['title'] : '';

        $where = ( count( $where ) ? '  ' . implode( ' AND ', $where ) : '' );	
        if($where)
                $where = 'WHERE'.$where;
        $oderby = ' ORDER BY '.$args['orderby'].' '.$args['order'];

        $rows = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ays_gallery ".$where.$oderby , OBJECT);

        return $rows;
    }  
	public function AYS_Gallery_Main(){
    	include_once AYS_GALL_DIR.'/classes/AYS_Gall_Main_List_Table.php';
        $list_table = new AYS_Gall_Main_List_Table();
        $list_table->prepare_items();
        
		?>
			<div class="wrap">

				
		        <h1 class="ays_welcome_note">Welcome To Gallery By AYS</h1>
	            <h2>
	                <?php
	                    echo ' <a href="admin.php?page=ays_gall_main&action=create" class="add-new-h2">' . esc_html( __( 'Add Gallery', 'ays' ) ) . '</a>';
	                    if ( ! empty( $_REQUEST['s'] ) ) {
	                            echo sprintf( '<span class="subtitle">'
	                                    . __( 'Search results for &#8220;%s&#8221;', 'ays_gallery' )
	                                    . '</span>', esc_html( $_REQUEST['s'] ) );
	                    }
	                ?>
	            </h2>
	            <?php do_action('ays_gall_messages' ); ?>
	            <form method="get" action="">
	                <input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ); ?>" />
	                <?php $list_table->search_box( __( 'Search Galleries', 'ays_gallery' ), 'ays_gallery' ); ?>
	                <?php $list_table->display(); ?>
	            </form>
				</div>
		<?php
	}
    function ays_gall_messages() {
        if ( empty( $_REQUEST['message'] ) )
                return;

        if ( 'created' == $_REQUEST['message'] )
                $updated_message = esc_html( __( 'Gallery created.', 'ays_gallery' ) );
        elseif ( 'edited' == $_REQUEST['message'] )
                $updated_message = esc_html( __( 'Gallery saved.', 'ays_gallery' ) );
        elseif ( 'deleted' == $_REQUEST['message'] )
                $updated_message = esc_html( __( 'Gallery deleted.', 'ays_gallery' ) );

        if ( empty( $updated_message ) )
                return;
        ?>
        <div id="message" class="updated">
                <p><?php echo $updated_message; ?></p>
        </div>
        <?php
    }
    public function create(){
    	global $wpdb;
    	include_once(AYS_GALL_DIR."/helpers/helper.php");
		?>
		<div class="wrap">
			<form action="" method="POST">
			<h2 class="ays_welcome_note"> Add New Gallery</h2>
		    <div class="row">
		        <div class="board">
		            <ul class="nav nav-tabs">
		                <div class="liner"></div>
		                <li rel-index="0" class="active">
		                    <a href="#step-1" class="btn" aria-controls="step-1" role="tab" data-toggle="tab">
		                        <span><i class="glyphicon glyphicon-cog"></i></span>
		                    </a>
		                </li>
		                <li rel-index="1">
		                    <a href="#step-2" class="btn disabled" aria-controls="step-2" role="tab" data-toggle="tab">
		                        <span><i class="glyphicon glyphicon-picture"></i></span>
		                    </a>
		                </li>
		                <li rel-index="2">
		                    <a href="#step-3" class="btn disabled" aria-controls="step-3" role="tab" data-toggle="tab">
		                        <span><i class="glyphicon glyphicon-plus"></i></span>
		                    </a>
		                </li>
		                <li rel-index="3">
		                    <a href="#step-4" class="btn disabled" aria-controls="step-4" role="tab" data-toggle="tab">
		                        <span><i class="glyphicon glyphicon-ok"></i></span>
		                    </a>
		                </li>
		            </ul>
		        </div>
		        <div class="tab-content">
		            <div role="tabpanel" class="tab-pane active" id="step-1">
		                <div class="col-md-12">
		                    <h3>General Options</h3>
		                    <div class="col-md-6">
		                        <div class="form-group">
		                            <label class="control-label">Title</label>
		                            <input  maxlength="100" type="text" required="required" id="ays_gallery_title" name="ays_gallery_title" class="form-control" placeholder="Enter Title"  />
		                        </div>
		                    </div>
		                    <div class="col-md-6">
		                        <div class="form-group">
		                            <label class="control-label">Description</label>
		                            <textarea  maxlength="100" type="text" required="required" id="ays_gallery_desc" name="ays_gallery_desc" class="form-control" placeholder="Enter Description"></textarea>
		                        </div>
		                    </div>
		                    <div class="col-md-6">
		                        <div class="form-group">
		                            <label class="control-label">Width</label>
		                            <input maxlength="100" type="number" id="ays_gallery_width" name="ays_gallery_width"  class="form-control" placeholder="Enter Width" />
		                        </div>
		                    </div> 
		                    <div class="col-md-6">
		                        <div class="form-group">
		                            <label class="control-label">Height</label>
		                            <input maxlength="100" type="number" id="ays_gallery_height" name="ays_gallery_height"  class="form-control" placeholder="Enter Height" />
		                        </div>
		                    </div> 
		                    <a id="step-1-next" class="btn btn-lg btn-primary nextBtn pull-right">Next</a>
		                
		                </div>
		            </div>
		            <div role="tabpanel" class="tab-pane" id="step-2">
		            	<div>
			                <div class="col-md-12 nar_set" id="nar_set_id">
			                <h3>Image Options</h3>
			                	<div class="col-md-3 nar_set_child">
			                		<div class="card">
			                			<a class="ays_remove_image" onclick="jQuery(this).parent().parent().remove()"><img src="<?php echo AYS_GALL_URL.'/images/remove.png'; ?>" width="50"></a>
										<img class="ays_ays_img" id="ays_ays_img0" alt="" style="width:100%">
										<input type="hidden" id="path_ays_ays_img0" name="path_ays_ays_img[]">
										<hr>
				                        <center><input type="button" value="Upload" onclick="openMediaUploader(event,'ays_ays_img0');return false;" class="btn btn-success"></center>
									  <hr>
									  <a class="accordion" onclick="ays_toggle_props()">Image Props</a>
									  <div class="panel">
					                        <div class="form-group">
					                            <label class="control-label">Title</label>
					                            <input type="text" id="ays_img_title0" name="ays_img_title[]" class="form-control">
					                        </div>	
					                        <div class="form-group">
					                            <label class="control-label">Alt</label>
					                            <input type="text" id="ays_img_alt0" name="ays_img_alt[]" class="form-control">
					                        </div>	
					                        <div class="form-group">
					                            <label class="control-label">Description</label>
					                            <textarea id="ays_img_desc0" class="form-control" name="ays_img_desc[]"></textarea>
					                        </div>	
					                        <div class="form-group">
					                            <label class="control-label">Url</label>
					                            <input type="url" id="ays_img_url0" name="ays_img_url[]" class="form-control">
					                        </div>						  	
									  </div>
									</div>
			                	</div>
			                	<div class="col-md-3 nar_bef nar_set_child">
			                		<div class="card nar_ays">

			                		</div>
			                	</div>
		                    </div>
		                	<div class="col-md-12">
		                    	<a id="step-2-next" class="btn btn-lg btn-primary pull-right">Next</a>
		                    </div>
		                </div>
		            </div>
		            <div role="tabpanel" class="tab-pane" id="step-3">
		                <div class="col-md-12">
		                	<h3>Styles Will Be Available In Pro Version</h3>
		                	
		                    <a id="step-3-next" class="btn btn-lg btn-primary pull-right">Next</a>
		                </div>
		            </div>
		            <div role="tabpanel" class="tab-pane" id="step-4">
		                <div class="col-md-12">
		                    <input type="submit" value="Save" id="step-4-next" name="ays_save" class="btn btn-lg btn-primary pull-right">
		                </div>
		            </div>
		        </div>
		    </form>
		    </div>

		    <?php 
		    	if(isset($_POST["ays_save"])){
		    		$_REQUEST['message'] = "created";
		    		header("Location: ?page=ays_gall_main");
		    		$ays_gallery_title = sanitize_text_field($_POST["ays_gallery_title"]);
		    		$ays_gallery_desc = sanitize_text_field($_POST["ays_gallery_desc"]);
		    		$ays_gallery_width = intval($_POST["ays_gallery_width"]);
		    		$ays_gallery_height = intval($_POST["ays_gallery_height"]);

		    		/*Image Options*/
		    		/*Getting informations in array*/
		    		$ays_image_paths_array = $_POST["path_ays_ays_img"];
		    		$ays_image_titles_array = $_POST["ays_img_title"];
		    		$ays_image_descs_array = $_POST["ays_img_desc"];
		    		$ays_image_alts_array = $_POST["ays_img_alt"];
		    		$ays_image_urls_array = $_POST["ays_img_url"];

		    		/*Now lets implode image props array to string*/
		    		$ays_image_paths = sanitize_text_field(implode("***",$ays_image_paths_array));
		    		$ays_image_titles = sanitize_text_field(implode("***",$ays_image_titles_array));
		    		$ays_image_descs = sanitize_text_field(implode("***",$ays_image_descs_array));
		    		$ays_image_alts = sanitize_text_field(implode("***",$ays_image_alts_array));
		    		$ays_image_urls = sanitize_text_field(implode("***",$ays_image_urls_array));

		    		$ays_gall_table = $wpdb->prefix."ays_gallery";

		    		/*Now fill our gallery table*/

		    		$wpdb->insert(
						$ays_gall_table,
						array(
							'title' => $ays_gallery_title,
							'description' => $ays_gallery_desc,
							'images' => $ays_image_paths,
							'images_titles' => $ays_image_titles,
							'images_descs' => $ays_image_descs,
			        		'images_alts' => $ays_image_alts,
							'images_urls' => $ays_image_urls,
			                'width' => $ays_gallery_width,
			                'height' => $ays_gallery_height,
						)
					);
		    	}?>
		    <script>
		    function ays_toggle_props(){
			    var acc = document.getElementsByClassName("accordion");
				var i;

				for (i = 0; i < acc.length; i++) {
				    acc[i].onclick = function(){
				        this.classList.toggle("active");
				        this.nextElementSibling.classList.toggle("show");
				    }
				}
			}
		    </script>

		    <script>
		    jQuery(document).ready(function(){
		    	jQuery("#nar_set_id").sortable({
			        revert: true
			    });
		    });
		    </script>

			
			<script>
				function openMediaUploader(e,id){
                    e.preventDefault();
                    var aysUploader = wp.media({
                        title: 'Upload',
                        button: {
                            text: 'Upload'
                        },
                        multiple: false
                    })
                    .on('select', function() {
                       var attachment = aysUploader.state().get('selection').first().toJSON();
                       jQuery("#"+id).attr("src",attachment.url);
                       jQuery("#path_"+id).val(attachment.url);
                    })
                    .open();

                    return false;

                }
			</script>
		</div>
		<?php	
    }
    public function edit(){
    	global $wpdb;
    	include_once(AYS_GALL_DIR."/helpers/helper.php");
    	$ays_gallery_table = $wpdb->prefix."ays_gallery";
    	$ays_gallery_id = $_GET["gall_id"];
		$res = $wpdb->get_row("SELECT * FROM ".$ays_gallery_table." WHERE id=".$ays_gallery_id."");
		?>
		<div class="wrap">
			<form action="" method="POST">
			<h2 class="ays_welcome_note"> Add New Gallery</h2>
		    <div class="row">
		        <div class="board">
		            <ul class="nav nav-tabs">
		                <div class="liner"></div>
		                <li rel-index="0" class="active">
		                    <a href="#step-1" class="btn" aria-controls="step-1" role="tab" data-toggle="tab">
		                        <span><i class="glyphicon glyphicon-cog"></i></span>
		                    </a>
		                </li>
		                <li rel-index="1">
		                    <a href="#step-2" class="btn disabled" aria-controls="step-2" role="tab" data-toggle="tab">
		                        <span><i class="glyphicon glyphicon-picture"></i></span>
		                    </a>
		                </li>
		                <li rel-index="2">
		                    <a href="#step-3" class="btn disabled" aria-controls="step-3" role="tab" data-toggle="tab">
		                        <span><i class="glyphicon glyphicon-plus"></i></span>
		                    </a>
		                </li>
		                <li rel-index="3">
		                    <a href="#step-4" class="btn disabled" aria-controls="step-4" role="tab" data-toggle="tab">
		                        <span><i class="glyphicon glyphicon-ok"></i></span>
		                    </a>
		                </li>
		            </ul>
		        </div>
		        <div class="tab-content">
		            <div role="tabpanel" class="tab-pane active" id="step-1">
		                <div class="col-md-12">
		                    <h3>General Options</h3>
		                    <div class="col-md-6">
		                        <div class="form-group">
		                            <label class="control-label">Title</label>
		                            <input  maxlength="100" type="text" required="required" id="ays_gallery_title" name="ays_gallery_title" class="form-control" placeholder="Enter Title"  value="<?php echo $res->title; ?>"/>
		                        </div>
		                    </div>
		                    <div class="col-md-6">
		                        <div class="form-group">
		                            <label class="control-label">Description</label>
		                            <textarea  maxlength="100" type="text" required="required" id="ays_gallery_desc" name="ays_gallery_desc" class="form-control" placeholder="Enter Description"><?php echo $res->description; ?></textarea>
		                        </div>
		                    </div>
		                    <div class="col-md-6">
		                        <div class="form-group">
		                            <label class="control-label">Width</label>
		                            <input maxlength="100" type="number" id="ays_gallery_width" name="ays_gallery_width"  class="form-control" placeholder="Enter Width"   value="<?php echo $res->width; ?>"/>
		                        </div>
		                    </div> 
		                    <div class="col-md-6">
		                        <div class="form-group">
		                            <label class="control-label">Height</label>
		                            <input maxlength="100" type="number" id="ays_gallery_height" name="ays_gallery_height"  class="form-control" placeholder="Enter Height"   value="<?php echo $res->height; ?>"/>
		                        </div>
		                    </div> 
		                    <a id="step-1-next" class="btn btn-lg btn-primary nextBtn pull-right">Next</a>
		                
		                </div>
		            </div>
		            <div role="tabpanel" class="tab-pane" id="step-2">
		            	<div>
			                <div class="col-md-12 nar_set" id="nar_set_id">
			                <h3>Image Options</h3>
			                <?php
			                $ays_image_paths = explode("***",$res->images);
			                $ays_image_titles = explode("***",$res->images_titles);
			                $ays_image_descs = explode("***",$res->images_descs);
			                $ays_image_alts = explode("***",$res->images_alts);
			                $ays_image_urls = explode("***",$res->images_urls);

			                foreach ($ays_image_paths as $ays_key => $ays_image_path) {
			                	?>
			                	<div class="col-md-3 nar_set_child">
			                		<div class="card">
			                			<a class="ays_remove_image" onclick="jQuery(this).parent().parent().remove()"><img src="<?php echo AYS_GALL_URL.'/images/remove.png'; ?>" width="50"></a>
										<img class="ays_ays_img" id="ays_ays_img<?php echo $ays_key; ?>" alt="" style="width:100%" src="<?php echo $ays_image_paths[$ays_key];?>">
										<input type="hidden" id="path_ays_ays_img<?php echo $ays_key; ?>" name="path_ays_ays_img[]" value="<?php echo $ays_image_paths[$ays_key];?>">
										<hr>
				                        <center><input type="button" value="Upload" onclick="openMediaUploader(event,'ays_ays_img<?php echo $ays_key; ?>');return false;" class="btn btn-success"></center>
									  <hr>
									  <a class="accordion" onclick="ays_toggle_props()">Image Props</a>
									  <div class="panel">
					                        <div class="form-group">
					                            <label class="control-label">Title</label>
					                            <input type="text" id="ays_img_title<?php echo $ays_key; ?>" name="ays_img_title[]" class="form-control" value="<?php echo $ays_image_titles[$ays_key]; ?>">
					                        </div>	
					                        <div class="form-group">
					                            <label class="control-label">Alt</label>
					                            <input type="text" id="ays_img_alt<?php echo $ays_key; ?>" name="ays_img_alt[]" class="form-control" value="<?php echo $ays_image_alts[$ays_key]; ?>">
					                        </div>	
					                        <div class="form-group">
					                            <label class="control-label">Description</label>
					                            <textarea id="ays_img_desc<?php echo $ays_key; ?>" class="form-control" name="ays_img_desc[]"><?php echo $ays_image_descs[$ays_key]; ?></textarea>
					                        </div>	
					                        <div class="form-group">
					                            <label class="control-label">Url</label>
					                            <input type="url" id="ays_img_url<?php echo $ays_key; ?>" name="ays_img_url[]" class="form-control" value="<?php echo $ays_image_urls[$ays_key]; ?>">
					                        </div>						  	
									  </div>
									</div>
			                	</div>
			                	<?php
			                }
			                ?>
			                	<div class="col-md-3 nar_bef nar_set_child">
			                		<div class="card nar_ays">

			                		</div>
			                	</div>
		                    </div>
		                	<div class="col-md-12">
		                    	<a id="step-2-next" class="btn btn-lg btn-primary pull-right">Next</a>
		                    </div>
		                </div>
		            </div>
		            <div role="tabpanel" class="tab-pane" id="step-3">
		                <div class="col-md-12">
		                	<center><img src="<?php echo AYS_GALL_URL.'/images/preview.jpg'; ?>"></center>
		                    <a id="step-3-next" class="btn btn-lg btn-primary pull-right">Next</a>
		                </div>
		            </div>
		            <div role="tabpanel" class="tab-pane" id="step-4">
		                <div class="col-md-12">
		                    <input type="submit" value="Save" id="step-4-next" name="ays_edit" class="btn btn-lg btn-primary pull-right">
		                </div>
		            </div>
		        </div>
		    </form>
		    </div>
		    <script>
		    function ays_toggle_props(){
			    var acc = document.getElementsByClassName("accordion");
				var i;

				for (i = 0; i < acc.length; i++) {
				    acc[i].onclick = function(){
				        this.classList.toggle("active");
				        this.nextElementSibling.classList.toggle("show");
				    }
				}
			}
		    </script>

		    <script>
		    jQuery(document).ready(function(){
		    	jQuery("#nar_set_id").sortable({
			        revert: true
			    });
		    });
		    </script>

			
			<script>
				function openMediaUploader(e,id){
                    e.preventDefault();
                    var aysUploader = wp.media({
                        title: 'Upload',
                        button: {
                            text: 'Upload'
                        },
                        multiple: false
                    })
                    .on('select', function() {
                       var attachment = aysUploader.state().get('selection').first().toJSON();
                       jQuery("#"+id).attr("src",attachment.url);
                       jQuery("#path_"+id).val(attachment.url);
                    })
                    .open();

                    return false;

                }
			</script>
		    <?php
		    if(isset($_POST["ays_edit"])){
		    		$_REQUEST['message'] = "edited";
		    		wp_redirect("?page=ays_gall_main");
		    		//AYS_Gall_Helper::ays_redirect("?page=ays_gall_main");
		    		$ays_gallery_title = sanitize_text_field($_POST["ays_gallery_title"]);
		    		$ays_gallery_desc = sanitize_text_field($_POST["ays_gallery_desc"]);
		    		$ays_gallery_width = intval($_POST["ays_gallery_width"]);
		    		$ays_gallery_height = intval($_POST["ays_gallery_height"]);

		    		/*Image Options*/
		    		/*Getting informations in array*/
		    		$ays_image_paths_array = $_POST["path_ays_ays_img"];
		    		$ays_image_titles_array = $_POST["ays_img_title"];
		    		$ays_image_descs_array = $_POST["ays_img_desc"];
		    		$ays_image_alts_array = $_POST["ays_img_alt"];
		    		$ays_image_urls_array = $_POST["ays_img_url"];

		    		/*Now lets implode image props array to string*/
		    		$ays_image_paths = sanitize_text_field(implode("***",$ays_image_paths_array));
		    		$ays_image_titles = sanitize_text_field(implode("***",$ays_image_titles_array));
		    		$ays_image_descs = sanitize_text_field(implode("***",$ays_image_descs_array));
		    		$ays_image_alts = sanitize_text_field(implode("***",$ays_image_alts_array));
		    		$ays_image_urls = sanitize_text_field(implode("***",$ays_image_urls_array));

		    		$ays_gall_table = $wpdb->prefix."ays_gallery";

		    		/*Now fill our gallery table*/
		    		$wpdb->update(
		                $ays_gall_table,
		                array(
							'title' => $ays_gallery_title,
							'description' => $ays_gallery_desc,
							'images' => $ays_image_paths,
							'images_titles' => $ays_image_titles,
							'images_descs' => $ays_image_descs,
			        		'images_alts' => $ays_image_alts,
							'images_urls' => $ays_image_urls,
			                'width' => $ays_gallery_width,
			                'height' => $ays_gallery_height,
		                ),
		                array( 'id' => $ays_gallery_id ),
		                array(
		                    '%s',
		                    '%s',
		                    '%s',
		                    '%s',
		                    '%s',
		                    '%s',
		                    '%s',
		                    '%d',
		                    '%d',
		                ),
		                array( '%d' )
		            );
		    } 
    }
    public function delete() {
        if ( $this->initial() )
                return;

        global $wpdb;
        $query = "DELETE FROM ".$wpdb->prefix."ays_gallery WHERE id = ".$this->id;
        $wpdb->query($query);
        $this->id = 0;
    }
    public static function get_instance( $ays_id ) {
        global $wpdb;
        $row = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ays_gallery WHERE id=".(int)$ays_id, OBJECT);

        self::$current = $ays_gallery = new self( $ays_id );
        $ays_gallery->id = $row->id;
        $ays_gallery->title = $row->title;
        $ays_gallery->description = $row->description;
        $ays_gallery->published = $row->published;

        return $ays_gallery;
    }
    public function initial() {
        return empty( $this->id );
    }
    public function message( $status, $filter = true ) {
            $messages = $this->prop( 'messages' );
            $message = isset( $messages[$status] ) ? $messages[$status] : '';

            return $message;
    }
}
?>