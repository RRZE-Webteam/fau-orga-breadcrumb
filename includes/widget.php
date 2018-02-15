<?php

namespace FAU\ORGA\Breadcrumb;

add_action( 'widgets_init', function(){
	register_widget( 'FAU\ORGA\Breadcrumb\FAU_ORGA_Breadcrumb_Widget' );
});

class FAU_ORGA_Breadcrumb_Widget extends \WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'fau-orga-breadcrumb',
            'description' => __('Anzeige der organisatorischen Breadcrumb.', 'fau-orga-breadcrumb' ),
        );
        parent::__construct( 'fau_orga_breadcrumb', 'FAU ORGA Breadcrumb', $widget_ops );
        
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        global $post;
        
        $yt_options             =   get_option('fau_orga_breadcrumb_plugin_options'); 
        extract( $args );

        $form_org   = (!empty($instance['org'])) ? $instance['org'] :'';
        $title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
        if( !empty( $form_org ) ) {
            wp_enqueue_style( 'fau-orga-breadcrumb');
            echo $before_widget;
            include( plugin_dir_path( __DIR__ ) . 'templates/widget-template.php');
            echo $after_widget;
        } 

    }

    

    /**
     * Outputs the options form on admin
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        global $default_fau_orga_data;
        $title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
        
        ?>
        
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Titel:', 'fau-orga-breadcrumb' ); ?></label> 
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" placeholder="title" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        <em><?php _e('Optionaler Titel für die Anzeige der Breadcrumb in Widget-Bereichen.', 'fau-orga-breadcrumb'  ) ?></em>
        </p>
        
        <p>
            
        <label for="<?php echo $this->get_field_id('org'); ?>"><?php esc_attr_e( 'Organisatorische Zuordnung:', 'fau-orga-breadcrumb' ); ?></label>
        <select class='widefat' id="<?php echo $this->get_field_id('org'); ?>"
        name="<?php echo $this->get_field_name('org'); ?>" type="text">
            <option value=""><?php _e('Auswählen', 'fau-orga-breadcrumb' ) ?></option>
        <?php        
        
        foreach($default_fau_orga_data as $key => $listdata) {
 
        }
        ?>
        </select>   
        </p>
        <p>
            <em><?php esc_attr_e( 'Bitte wählen Sie hier die Einrichtung aus, zu dem der aktuelle Webauftritte organisatorisch direkt untergeordnet ist.', 'fau-orga-breadcrumb' ); ?></em>
        </p>
       
        <?php
    }

   /*
     * Im Widget-Screen werden die alten Eingaben mit
     * den neuen Eingaben ersetzt und gespeichert.  
     */
    public function update( $new_instance, $old_instance ) { 
        
        $instance = $old_instance;
        $instance[ 'title' ]        = strip_tags( $new_instance[ 'title' ] );
        $instance[ 'org' ]           = strip_tags( $new_instance[ 'org' ] );

        return $instance;
    } 

}