<?php
/**
 * ThemeWaves Custom Menu
 */
class Waves_CustomMenu extends Walker_Nav_Menu {
    var $isMega=false;
    var $column=false;
    var $columnCnt=0;
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $class = $attr = '';
        if($this->isMega&&$depth===1){
            $class.=' mega-menu-items';
        }elseif($this->isMega&&$depth===0){
            $class.=' waves-mega-menu '.$this->column;
            $attr .=' data-col="'.$this->column.'"';
        }
        $output .= "\n$indent<ul class=\"sub-menu".$class."\"".$attr.">\n";
    }
    function end_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
    }
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        /**
         * Filter the CSS class(es) applied to a menu item's <li>.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        if(isset($item->megamenu)&&$item->megamenu&&$depth===0){
            $this->isMega=true;
            if(!empty($item->column)&&$depth===0){
                $this->column='column-'.$item->column;
            }else{
                $this->column='column-2';
            }
        }
        if($this->isMega&&$depth===1){
            $class_names .=' '.$depth.'-'.$this->columnCnt;
            if($class_names&&$this->columnCnt===0){
                $class_names.=' row-start';
            }
            if(++$this->columnCnt >= intval(str_replace('column-', '', $this->column))){
                $this->columnCnt=0;
            }
        }
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filter the ID applied to a menu item's <li>.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = esc_url(! empty( $item->url )        ? $item->url        : '');

        /**
         * Filter the HTML attributes applied to a menu item's <a>.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                        $attributes .= ' ' . $attr . '="' . $value . '"';
                }
        }
        $show = true;
        $hot=$new=$item_output='';
        if($depth===1&&isset($item->hidetitle)&&$item->hidetitle){$show = false;}
        if($depth>1&&isset($item->hot)&&$item->hot){$hot='<i class="mega-hot">'.esc_html__('hot','ninetysix').'</i>';}
        if($depth>1&&isset($item->new)&&$item->new){$new='<i class="mega-new">'.esc_html__('new','ninetysix').'</i>';}
        if($show){
            $item_output = $args->before;
            if($this->isMega&&$depth===1){
                $item_output .= '<div class="mega-menu-title">';
            }else{
                $item_output .= '<a'. $attributes .'>';
            }
                /** This filter is documented in wp-includes/post-template.php */
                $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            if($this->isMega&&$depth===1){
                $item_output .= '</div>';
            }else{
                $item_output .= $hot.$new.'</a>';
            }
            $item_output .= $args->after;
        }
        /**
         * Filter a menu item's starting output.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if($depth===0){$this->isMega=false;$this->columnCnt=0;}
        $output .= "</li>\n";
    }
}

/**
 * Add Custom Fields to ThemeWaves Custom Menu
 */
add_filter('wp_setup_nav_menu_item','waves_custom_menu_add_custom_fields');
function waves_custom_menu_add_custom_fields( $menu_item ) {
    $menu_item->megamenu   = get_post_meta( $menu_item->ID, '_waves_megamenu',  true );
    $menu_item->column     = get_post_meta( $menu_item->ID, '_waves_column',    true );
    $menu_item->hidetitle  = get_post_meta( $menu_item->ID, '_waves_hidetitle', true );
    $menu_item->hot        = get_post_meta( $menu_item->ID, '_waves_hot', true );
    $menu_item->new        = get_post_meta( $menu_item->ID, '_waves_new', true );
    return $menu_item;
}

/**
 * ThemeWaves Custom Menu Edit
 */
add_filter( 'wp_edit_nav_menu_walker', 'waves_custom_edit_nav_menu_walker' , 100);
function waves_custom_edit_nav_menu_walker($name){return 'Waves_CustomMenuEdit';}
class Waves_CustomMenuEdit extends Walker_Nav_Menu {
    /**
     * Starts the list before the elements are added.
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {}

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker_Nav_Menu::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   Not used.
     */
    function end_lvl( &$output, $depth = 0, $args = array() ) {}

    /**
     * Start the element output.
     *
     * @see Walker_Nav_Menu::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   Not used.
     * @param int    $id     Not used.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $_wp_nav_menu_max_depth;
        $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

        ob_start();
        $item_id = esc_attr( $item->ID );
        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        );

        $original_title = '';
        if ( 'taxonomy' == $item->type ) {
            $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
            if ( is_wp_error( $original_title ) )
                $original_title = false;
        } elseif ( 'post_type' == $item->type ) {
            $original_object = get_post( $item->object_id );
            $original_title = get_the_title( $original_object->ID );
        }

        $classes = array(
            'menu-item menu-item-depth-' . $depth,
            'menu-item-' . esc_attr( $item->object ),
            'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
        );

        $title = $item->title;

        if ( ! empty( $item->_invalid ) ) {
            $classes[] = 'menu-item-invalid';
            /* translators: %s: title of menu item which is invalid */
            $title = sprintf( esc_html__( '%s (Invalid)', 'ninetysix'), $item->title );
        } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
            $classes[] = 'pending';
            /* translators: %s: title of menu item in draft status */
            $title = sprintf( esc_html__('%s (Pending)', 'ninetysix'), $item->title );
        }

        $title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

        $submenu_text = '';
        if ( 0 == $depth )
            $submenu_text = 'display: none;'; ?>
        <li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo implode(' ', $classes ); ?>">
            <dl class="menu-item-bar">
                <dt class="menu-item-handle">
                    <span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" style="<?php echo esc_attr($submenu_text); ?>"><?php esc_html_e( 'sub item', 'ninetysix'); ?></span></span>
                    <span class="item-controls">
                        <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                        <span class="item-order hide-if-js">
                                    <a href="<?php
                                            echo wp_nonce_url(
                                                    add_query_arg(
                                                            array(
                                                                    'action' => 'move-up-menu-item',
                                                                    'menu-item' => $item_id,
                                                            ),
                                                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                                    ),
                                                    'move-menu_item'
                                            );
                                    ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'ninetysix'); ?>">&#8593;</abbr></a>
                                    |
                                    <a href="<?php
                                            echo wp_nonce_url(
                                                    add_query_arg(
                                                            array(
                                                                    'action' => 'move-down-menu-item',
                                                                    'menu-item' => $item_id,
                                                            ),
                                                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                                    ),
                                                    'move-menu_item'
                                            );
                                    ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'ninetysix'); ?>">&#8595;</abbr></a>
                        </span>
                        <a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" title="<?php esc_attr_e('Edit Menu Item', 'ninetysix'); ?>" href="<?php echo esc_url(( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) )); ?>">
                            <?php esc_html_e( 'Edit Menu Item', 'ninetysix'); ?>
                        </a>
                    </span>
                </dt>
            </dl>
            <div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php
                if( 'custom' == $item->type ) : ?>
                    <p class="field-url description description-wide">
                        <label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
                            <?php esc_html_e( 'URL', 'ninetysix'); ?><br />
                            <input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                        </label>
                    </p><?php
                endif; ?>
                <p class="description description-thin">
                    <label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
                        <?php esc_html_e( 'Navigation Label', 'ninetysix'); ?><br />
                        <input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                    </label>
                </p>
                <p class="description description-thin">
                    <label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>">
                        <?php esc_html_e( 'Title Attribute', 'ninetysix'); ?><br />
                        <input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                    </label>
                </p>
                <p class="field-link-target description">
                    <label for="edit-menu-item-target-<?php echo esc_attr($item_id); ?>">
                        <input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->target, '_blank' ); ?> />
                        <?php esc_html_e( 'Open link in a new window/tab', 'ninetysix'); ?>
                    </label>
                </p>
                <p class="field-css-classes description description-thin">
                    <label for="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>">
                        <?php esc_html_e( 'CSS Classes (optional)', 'ninetysix'); ?><br />
                        <input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                    </label>
                </p>
                <p class="field-xfn description description-thin">
                    <label for="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>">
                        <?php esc_html_e( 'Link Relationship (XFN)', 'ninetysix'); ?><br />
                        <input type="text" id="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                    </label>
                </p>
                <p class="field-description description description-wide">
                    <label for="edit-menu-item-description-<?php echo esc_attr($item_id); ?>">
                        <?php esc_html_e( 'Description', 'ninetysix'); ?><br />
                        <textarea id="edit-menu-item-description-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                        <span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.', 'ninetysix'); ?></span>
                    </label>
                </p>
                <p class="field-move hide-if-no-js description description-wide">
                    <label>
                        <span><?php esc_html_e( 'Move', 'ninetysix'); ?></span>
                        <a href="#" class="menus-move-up"><?php esc_html_e( 'Up one', 'ninetysix'); ?></a>
                        <a href="#" class="menus-move-down"><?php esc_html_e( 'Down one', 'ninetysix'); ?></a>
                        <a href="#" class="menus-move-left"></a>
                        <a href="#" class="menus-move-right"></a>
                        <a href="#" class="menus-move-top"><?php esc_html_e( 'To the top', 'ninetysix'); ?></a>
                    </label>
                </p>
                <div class="waves-menu-options">
                    <h4><?php esc_html_e('Custom Options','ninetysix'); ?></h4>
                    <p class="field-waves field-waves-hide-title description description-thin">
                        <label for="edit-menu-hide-title-<?php echo esc_attr($item_id); ?>">
                            <input type="checkbox" id="edit-menu-hide-title-<?php echo esc_attr($item_id); ?>" class="edit-menu-item-waves" name="menu-hide-title[<?php echo esc_attr($item_id); ?>]" value="1" <?php echo checked( !empty( $item->hidetitle ), 1, false ); ?> />
                            <?php esc_html_e( 'Hide','ninetysix'); ?>
                        </label>
                    </p>
                    <p class="field-waves field-waves-hot description description-thin">
                        <label for="edit-menu-hot-<?php echo esc_attr($item_id); ?>">
                            <input type="checkbox" id="edit-menu-hot-<?php echo esc_attr($item_id); ?>" class="edit-menu-item-waves" name="menu-hot[<?php echo esc_attr($item_id); ?>]" value="1" <?php echo checked( !empty( $item->hot ), 1, false ); ?> />
                            <?php esc_html_e( 'Hot','ninetysix'); ?>
                        </label>
                    </p>
                    <p class="field-waves field-waves-new description description-thin">
                        <label for="edit-menu-new-<?php echo esc_attr($item_id); ?>">
                            <input type="checkbox" id="edit-menu-new-<?php echo esc_attr($item_id); ?>" class="edit-menu-item-waves" name="menu-new[<?php echo esc_attr($item_id); ?>]" value="1" <?php echo checked( !empty( $item->new ), 1, false ); ?> />
                            <?php esc_html_e( 'New','ninetysix'); ?>
                        </label>
                    </p>
                    <p class="field-waves field-waves-is-mega description description-thin">
                        <label for="edit-menu-is-mega-<?php echo esc_attr($item_id); ?>">
                            <input type="checkbox" id="edit-menu-is-mega-<?php echo esc_attr($item_id); ?>" class="edit-menu-item-waves" name="menu-is-mega[<?php echo esc_attr($item_id); ?>]" value="1" <?php echo checked( !empty( $item->megamenu ), 1, false ); ?> />
                            <?php esc_html_e( 'Is Mega Menu','ninetysix'); ?>
                        </label>
                    </p>
                    <p class="field-waves field-waves-column description description-thin">
                        <label for="edit-menu-column-<?php echo esc_attr($item_id); ?>">
                            <?php esc_html_e( 'Column','ninetysix'); ?>
                            <?php if(empty($item->column)){$item->column='2';} ?>
                            <select id="edit-menu-column-<?php echo esc_attr($item_id); ?>" class="edit-menu-item-waves" name="menu-column[<?php echo esc_attr($item_id); ?>]">
                                <option value="2"<?php if($item->column==='2'){echo ' selected="selected"';} ?>><?php esc_html_e( '2 Columns','ninetysix'); ?></option>
                                <option value="3"<?php if($item->column==='3'){echo ' selected="selected"';} ?>><?php esc_html_e( '3 Columns','ninetysix'); ?></option>
                                <option value="4"<?php if($item->column==='4'){echo ' selected="selected"';} ?>><?php esc_html_e( '4 Columns','ninetysix'); ?></option>
                                <option value="5"<?php if($item->column==='5'){echo ' selected="selected"';} ?>><?php esc_html_e( '5 Columns','ninetysix'); ?></option>
                            </select>
                        </label>
                    </p>
                </div>
                <div class="menu-item-actions description-wide submitbox"><?php
                    if( 'custom' != $item->type && $original_title !== false ) : ?>
                        <p class="link-to-original"><?php printf( esc_html__('Original: %s', 'ninetysix'), '<a href="' . esc_url( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?></p><?php
                    endif; ?>
                        <a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
                        echo wp_nonce_url(
                                add_query_arg(
                                        array(
                                                'action' => 'delete-menu-item',
                                                'menu-item' => $item_id,
                                        ),
                                        admin_url( 'nav-menus.php' )
                                ),
                                'delete-menu_item_' . $item_id
                        ); ?>">
                            <?php esc_html_e( 'Remove', 'ninetysix'); ?>
                        </a>
                        <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) ); ?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Cancel', 'ninetysix'); ?></a>
                </div>
                <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
                <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
            </div><!-- .menu-item-settings-->
            <ul class="menu-item-transport"></ul><?php
        $output .= ob_get_clean();
    }
}
add_action('admin_init', 'waves_custom_menu_admin_scripts');
function waves_custom_menu_admin_scripts(){
    if(basename( $_SERVER['PHP_SELF']) == "nav-menus.php" ){
        wp_enqueue_script('waves-custom-menu-admin-scripts',WAVES_FW_DIR.'assets/js/admin-waves-custom-menu.js',array('jquery', 'jquery-ui-sortable'), false, true ); 
    }
}
add_action('admin_print_styles', 'waves_custom_menu_admin_styles');
function waves_custom_menu_admin_styles() {
    if(basename( $_SERVER['PHP_SELF']) == "nav-menus.php" ){
        wp_enqueue_style('waves-custom-menu-admin-styles', WAVES_FW_DIR.'assets/css/admin-waves-custom-menu.css');
    }
}

/**
 * Save menu custom fields
 */
add_action( 'wp_update_nav_menu_item', 'waves_custom_menu_item', 100, 3);
function waves_custom_menu_item( $menu_id, $menu_item_db_id, $args ) {
    if (isset( $_REQUEST['menu-is-mega'][$menu_item_db_id])) {
        update_post_meta( $menu_item_db_id, '_waves_megamenu', 1 );
    }else{
        update_post_meta( $menu_item_db_id, '_waves_megamenu', 0 );
    }
    if (isset( $_REQUEST['menu-column'][$menu_item_db_id])) {
        update_post_meta( $menu_item_db_id, '_waves_column', $_REQUEST['menu-column'][$menu_item_db_id] );
    }
    if (isset( $_REQUEST['menu-hide-title'][$menu_item_db_id])) {
        update_post_meta( $menu_item_db_id, '_waves_hidetitle', 1 );
    }else{
        update_post_meta( $menu_item_db_id, '_waves_hidetitle', 0 );
    }
    if (isset( $_REQUEST['menu-hot'][$menu_item_db_id])) {
        update_post_meta( $menu_item_db_id, '_waves_hot', 1 );
    }else{
        update_post_meta( $menu_item_db_id, '_waves_hot', 0 );
    }
    if (isset( $_REQUEST['menu-new'][$menu_item_db_id])) {
        update_post_meta( $menu_item_db_id, '_waves_new', 1 );
    }else{
        update_post_meta( $menu_item_db_id, '_waves_new', 0 );
    }
}